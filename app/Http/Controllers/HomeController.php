<?php

namespace App\Http\Controllers;

use App\Deposit;
use App\Forex;
use App\Http\Controllers\Util\Logger;
use App\Notifications\PaymentReceived;
use App\PaypalData;
use App\Transaction;
use App\UserAddress;
use App\UserBalance;
use App\UserBank;
use App\UserDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Log;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\ProductionEnvironment;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersGetRequest;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->req = new Request();
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $currentBal = UserBalance::where('user_id', auth()->user()->id)
            ->where('status',1)
            ->orderBy('id', 'desc')
            ->first();

        $transactions = Transaction::where('user_id', auth()->user()->id)->orderBy('id', 'desc')->limit(10)->get();

        if (is_null($currentBal)){
            $bal = 0;
        }else{
            $bal = $currentBal->balance;
        }

        $percentage = 0;

        $emailVerified = auth()->user()->email_verified_at;
        is_null($emailVerified) ?  $percentage=$percentage+0 : $percentage=$percentage+25;

        $phoneVerified = auth()->user()->phone_verified_at;
        is_null($phoneVerified) ? $percentage=$percentage+0 : $percentage=$percentage+25;

        $userBank = UserBank::where('user_id',auth()->user()->id)->first();
         is_null($userBank) ? $percentage=$percentage+0 : $percentage=$percentage+25;

        $userIdentity = UserDetails::where('user_id',auth()->user()->id)->first();
         is_null($userIdentity) ? $percentage=$percentage+0 : $percentage=$percentage+25;


        $userAddress = UserAddress::where('user_id',auth()->user()->id)->first();



        return view('dashboard', compact('bal','transactions','emailVerified','phoneVerified','userBank','userIdentity','percentage','userAddress'));
    }

    public static function client()
    {
        return new PayPalHttpClient(self::environment());
    }

    public static function environment()
    {
        //$clientId = "AfxwMq3uk8eAEExndpaAigbwcwaH-8UKXXd9tQT_6o4P6_QO6ivzMVxC1Qk7uQrvpZ0mK51ju4cba3rS"; //sandbox;
        $clientId = "AeJcD0QwLDMAQZH5HHNDfJBKvIxDMd0SWKca3rrX3IdhK62xLu0EInhkOScSskKtxVhNBjroPkIX0Oeu"; //live;
//        $clientSecret = "EJs4udErZIsmm1rxvSR_6JIVqojRadq_oDkLLN1nQuqkaq5k8fSKX6CZQvUQzf3dLGdJthYh6xNLgHd3"; //sandbox;
        $clientSecret = "EEKCrsLBLWIVx4MTf8Qi1t2uTVNymwpUCxCnhsoZuAFpHPzpqBVliAiIBeSyHoEpeQya8TJdkgrDvXDM"; //live;
        return new ProductionEnvironment($clientId, $clientSecret);
    }


    public function verify_order_id($orderID)
    {

        // 3. Call PayPal to get the transaction details
        $client =$this->client();
        $response = $client->execute(new OrdersGetRequest($orderID));

        /**
         *Enable the following line to print complete response as JSON.
         */


        Log::debug( \GuzzleHttp\json_decode(\GuzzleHttp\json_encode($response, true),true) );


//        Logger::log( \GuzzleHttp\json_encode($response->result));
        Log::debug(\GuzzleHttp\json_encode($response->result, true));

//        Log::debug("Order ID: {$response->result->id}\n");
//        Log::error("Intent: {$response->result->intent}\n");

        $statusCode = $response->statusCode;
        $status = $response->result->status;
        $orderID = $response->result->id;
        $payerGivenName = $response->result->payer->name->given_name;
        $payerSurName = $response->result->payer->name->surname;
        $currency = $response->result->purchase_units[0]->amount->currency_code;
        $amount = $response->result->purchase_units[0]->amount->value;
        $payeeEmail = $response->result->purchase_units[0]->payee->email_address;
        $customID = $response->result->purchase_units[0]->custom_id;
        $paymentID = $response->result->purchase_units[0]->payments->captures[0]->id;

        Log::debug("Status Code: {$statusCode}\n");
        Log::debug("Status: {$status}\n");
        Log::debug("order id: {$orderID}\n");
        Log::debug("payer given name: {$payerGivenName}\n");
        Log::debug("payer sur name: {$payerSurName}\n");
        Log::debug("currency: {$currency}\n");
        Log::debug("amount: {$amount}\n");
        Log::debug("payee email: {$payeeEmail}\n");
        Log::debug("custom id: {$customID}\n");
        Log::debug("payment id: {$paymentID}\n");

        $paypalData = new PaypalData();
        $paypalData->status_code = $statusCode;
        $paypalData->status = $status;
        $paypalData->order_id = $orderID;
        $paypalData->payment_id = $paymentID;
        $paypalData->custom_id = $customID;
        $paypalData->payer_given_name = $payerGivenName;
        $paypalData->payer_sur_name = $payerSurName;
        $paypalData->currency = $currency;
        $paypalData->amount = $amount;
        $paypalData->payee_email = $payeeEmail;

            DB::transaction(function () use ($paypalData){

                if ($paypalData->saveOrFail()){

                    $deposit = new Deposit();
                    $deposit->user_id = $paypalData->custom_id;
                    $deposit->amount = Forex::where('status',1)->orderBy('forex_id','desc')->first()->usd_rate()*($paypalData->amount);
                    $deposit->channel = "PAYPAL";
                    $deposit->confirmation_code = $paypalData->payment_id;

                    if (is_null(Deposit::where('confirmation_code',$paypalData->payment_id)->first())){
                        if ($deposit->saveOrFail()){
                            $transaction = new Transaction();
                            $transaction->user_id = $deposit->user_id;
                            $transaction->type = "CREDIT";
                            $transaction->ref_id = $deposit->id;

                            if ($transaction->saveOrFail()){
                                $currentBal = UserBalance::where('user_id', $transaction->user_id)->where('status',1)->orderBy('id', 'desc')->first();

                                if (is_null($currentBal)){
                                    $oldBal = 0;
                                }else{
                                    $oldBal = $currentBal->balance;
                                }

                                $userBalance = new UserBalance();
                                $userBalance->user_id = $transaction->user_id;
                                $userBalance->amount =  $deposit->amount;
                                $userBalance->balance =  $deposit->amount + $oldBal;

                                if ($userBalance->saveOrFail()){
                                    //notify customer
                                    auth()->user()->notify(new PaymentReceived($userBalance->amount, $userBalance->balance, "PAYPAL", $deposit->confirmation_code));
                                }

                            }

                        }

                    }
                }

            });

    }


}
