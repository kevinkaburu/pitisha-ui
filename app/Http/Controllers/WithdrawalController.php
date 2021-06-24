<?php

namespace App\Http\Controllers;

use App\Account;
use App\Deposit;
use App\Forex;
use App\Notifications\PaymentReceived;
use App\PaypalData;
use App\Transaction;
use App\UserAddress;
use App\UserBalance;
use App\UserBank;
use App\UserDetails;
use App\UserMobileAccount;
use App\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\ProductionEnvironment;
use PayPalCheckoutSdk\Orders\OrdersGetRequest;

class WithdrawalController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $withdrawals = Withdrawal::where('user_id', auth()->user()->id)->orderBy('id','desc')->paginate(20);
        return view('withdrawals/index', compact('withdrawals'));
    }

    public function from_paypal_to_mobile()
    {
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

        return view('withdrawals/paypal_mobile', compact('bal','transactions','emailVerified','phoneVerified','userBank','userIdentity','percentage','userAddress'));
    }
    public function verify_paypal_mobile_withdraw($orderID)
    {

        // 3. Call PayPal to get the transaction details
        $client =$this->client();
        $response = $client->execute(new OrdersGetRequest($orderID));

        /**
         *Enable the following line to print complete response as JSON.
         */


        Log::debug( \GuzzleHttp\json_decode(\GuzzleHttp\json_encode($response, true),true) );


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
                                self::paypal_mobile_withdrawal($deposit->amount);
                            }

                        }

                    }

                }
            }

        });

    }
    public function paypal_mobile_withdrawal($amount)
    {

        $currentBal = UserBalance::where('user_id',auth()->user()->id)
            ->where('status',1)
            ->orderBy('id', 'desc')
            ->first();

        if (empty($currentBal)){
            Session::flash('error', "Insufficient balance, please top up your account to be able to transact");
            return redirect('withdraw/paypal/mobile');

        }else{
           if ($currentBal->balance < $amount){
               Session::flash('error', "Insufficient balance, you do not have enough Pitsha balance to send Ksh. ".$amount);
               return redirect('withdraw/paypal/mobile');
           }
           //add fees check here
        }


        $userMobileAccount = UserMobileAccount::where('user_id',auth()->user()->id)->first();

        $ENDPOINT = "http://127.0.0.1:8111/pitisha/sendmoney/";
        $HEADER = "Content-Type: application/json";


        $payload = array(
            "user_id"=>auth()->user()->id,
            "msisdn"=>Account::find($userMobileAccount->account_id)->account_number,
            "account_id"=>$userMobileAccount->account_id,
            "amount"=>$amount,
        );

        //dd($payload);

        //$fp = fopen('/var/log/lotto/curl.log', 'w');
        $body = \GuzzleHttp\json_encode($payload, JSON_PRETTY_PRINT);


        //dd($encBody);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $ENDPOINT); // point to endpoint
        curl_setopt($ch,CURLOPT_HTTPHEADER,array($HEADER));

        curl_setopt($ch, CURLOPT_VERBOSE, true);
        // curl_setopt($ch, CURLOPT_STDERR, $fp);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);  //data
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);// request time out
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, '0'); // no ssl verifictaion
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, '0');


        $result=curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        Log::debug("Send Money PayPal direct M-Pesa withdrawal ==>". print_r($result, true));

        //print_r($encBody);
//        print_r($result);
//        exit();


//        dd($result);

        if($httpcode == 200 || $httpcode ==201){

            if (empty($currentBal)){
                $oldBal = 0;
            }else{
                $oldBal = $currentBal->balance;
            }

            $withdrawAmount =  -1 * abs($amount);

            $userBalance = new UserBalance();
            $userBalance->user_id = auth()->user()->id;
            $userBalance->amount =  $withdrawAmount;
            $userBalance->balance =  $oldBal + $withdrawAmount;
            $userBalance->saveOrFail();
            Session::flash('success', \GuzzleHttp\json_decode($result, true)['message']);

        }


//        Session::flash('success', json_decode($result, true)['description']);


//        Session::flash("success", "Permission created successfully.");
        return redirect('withdraw/paypal/mobile');
    }




    public function from_paypal_to_bank()
    {
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

        return view('withdrawals/paypal_bank', compact('bal','transactions','emailVerified','phoneVerified','userBank','userIdentity','percentage','userAddress'));
    }
    public function verify_paypal_bank_withdraw($orderID)
    {

        // 3. Call PayPal to get the transaction details
        $client =$this->client();
        $response = $client->execute(new OrdersGetRequest($orderID));

        /**
         *Enable the following line to print complete response as JSON.
         */


        Log::debug( \GuzzleHttp\json_decode(\GuzzleHttp\json_encode($response, true),true) );


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
                                self::paypal_bank_withdrawal($deposit->amount);
                            }

                        }

                    }

                }
            }

        });

    }
    public function paypal_bank_withdrawal($amount)
    {

        $currentBal = UserBalance::where('user_id',auth()->user()->id)
            ->where('status',1)
            ->orderBy('id', 'desc')
            ->first();

        if (empty($currentBal)){
            Session::flash('error', "Insufficient balance, please top up your account to be able to transact");
            return redirect('withdraw/paypal/bank');

        }else{
            if ($currentBal->balance < $amount){
                Session::flash('error', "Insufficient balance, you do not have enough Pitsha balance to send Ksh. ".$amount);
                return redirect('withdraw/paypal/bank');
            }
            //add fees check here
        }


        $userBankAccount = UserBank::where('user_id',auth()->user()->id)->first();

        $ENDPOINT = "http://127.0.0.1:8111/pitisha/sendtobank/";
        $HEADER = "Content-Type: application/json";


        $payload = array(
            "user_id"=>auth()->user()->id,
            "account"=>optional(Account::find($userBankAccount->account_id))->account_number,
            "paybill"=>optional(optional(Account::find($userBankAccount->account_id))->provider)->paybill,
            "account_id"=>$userBankAccount->account_id,
            "amount"=>$amount,
        );
        //dd($payload);

        //$fp = fopen('/var/log/lotto/curl.log', 'w');
        $body = \GuzzleHttp\json_encode($payload, JSON_PRETTY_PRINT);


        //dd($encBody);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $ENDPOINT); // point to endpoint
        curl_setopt($ch,CURLOPT_HTTPHEADER,array($HEADER));

        curl_setopt($ch, CURLOPT_VERBOSE, true);
        // curl_setopt($ch, CURLOPT_STDERR, $fp);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);  //data
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);// request time out
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, '0'); // no ssl verifictaion
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, '0');


        $result=curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        Log::debug("Send Money PayPal direct bank withdrawal ==>". print_r($result, true));

        //print_r($encBody);
//        print_r($result);
//        exit();


//        dd($result);

        if($httpcode == 200 || $httpcode ==201){

            if (empty($currentBal)){
                $oldBal = 0;
            }else{
                $oldBal = $currentBal->balance;
            }

            $withdrawAmount =  -1 * abs($amount);

            $userBalance = new UserBalance();
            $userBalance->user_id = auth()->user()->id;
            $userBalance->amount =  $withdrawAmount;
            $userBalance->balance =  $oldBal + $withdrawAmount;
            $userBalance->saveOrFail();
            Session::flash('success', \GuzzleHttp\json_decode($result, true)['message']);

        }


//        Session::flash('success', json_decode($result, true)['description']);


//        Session::flash("success", "Permission created successfully.");
        return redirect('withdraw/paypal/bank');
    }













    public function mobile_withdrawal(Request $request)
    {

        $this->validate($request, [
            'amount' => 'required',
            'account_id' => 'required'
        ],[
            'account_id.required' => "The beneficiary field is required"
        ]);

        $currentBal = UserBalance::where('user_id',auth()->user()->id)
            ->where('status',1)
            ->orderBy('id', 'desc')
            ->first();

        if (empty($currentBal)){
            Session::flash('error', "Insufficient balance, please top up your account to be able to transact");
            return redirect('withdraw');

        }else{
           if ($currentBal->balance < $request->amount){
               Session::flash('error', "Insufficient balance, you do not have enough Pitsha balance to send Ksh. ".$request->amount);
               return redirect('withdraw');
           }
           //add fees check here
        }


        $ENDPOINT = "http://127.0.0.1:8111/pitisha/sendmoney/";
        $HEADER = "Content-Type: application/json";


        $payload = array(
            "user_id"=>auth()->user()->id,
            "msisdn"=>Account::find($request->account_id)->account_number,
            "account_id"=>$request->account_id,
            "amount"=>$request->amount,
        );

        //dd($payload);

        //$fp = fopen('/var/log/lotto/curl.log', 'w');
        $body = \GuzzleHttp\json_encode($payload, JSON_PRETTY_PRINT);


        //dd($encBody);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $ENDPOINT); // point to endpoint
        curl_setopt($ch,CURLOPT_HTTPHEADER,array($HEADER));

        curl_setopt($ch, CURLOPT_VERBOSE, true);
        // curl_setopt($ch, CURLOPT_STDERR, $fp);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);  //data
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);// request time out
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, '0'); // no ssl verifictaion
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, '0');


        $result=curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        Log::debug("Send Money ==>". print_r($result, true));

        //print_r($encBody);
//        print_r($result);
//        exit();


//        dd($result);

        if($httpcode == 200 || $httpcode ==201){

            if (empty($currentBal)){
                $oldBal = 0;
            }else{
                $oldBal = $currentBal->balance;
            }

            $withdrawAmount =  -1 * abs($request->amount);

            $userBalance = new UserBalance();
            $userBalance->user_id = auth()->user()->id;
            $userBalance->amount =  $withdrawAmount;
            $userBalance->balance =  $oldBal + $withdrawAmount;
            $userBalance->saveOrFail();
            Session::flash('success', \GuzzleHttp\json_decode($result, true)['message']);

        }


//        Session::flash('success', json_decode($result, true)['description']);


//        Session::flash("success", "Permission created successfully.");
        return redirect('withdraw');
    }
    public function bank_withdrawal(Request $request)
    {

        $this->validate($request, [
            'amount' => 'required',
            'account_id' => 'required'
        ],[
            'account_id.required' => "The beneficiary field is required"
        ]);

        $currentBal = UserBalance::where('user_id',auth()->user()->id)
            ->where('status',1)
            ->orderBy('id', 'desc')
            ->first();

        if (empty($currentBal)){
            Session::flash('error', "Insufficient balance, please top up your account to be able to transact");
            return redirect('withdraw');

        }else{
            if ($currentBal->balance < $request->amount){
                Session::flash('error', "Insufficient balance, you do not have enough Pitsha balance to send Ksh. ".$request->amount);
                return redirect('withdraw');
            }
            //add fees check here
        }



        $ENDPOINT = "http://127.0.0.1:8111/pitisha/sendtobank/";
        $HEADER = "Content-Type: application/json";


        $payload = array(
            "user_id"=>auth()->user()->id,
            "account"=>optional(Account::find($request->account_id))->account_number,
            "paybill"=>optional(optional(Account::find($request->account_id))->provider)->paybill,
            "account_id"=>$request->account_id,
            "amount"=>$request->amount,
        );

        Log::debug("Payload ====> ", $payload);

        //$fp = fopen('/var/log/lotto/curl.log', 'w');
        $body = \GuzzleHttp\json_encode($payload, JSON_PRETTY_PRINT);


        //dd($encBody);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $ENDPOINT); // point to endpoint
        curl_setopt($ch,CURLOPT_HTTPHEADER,array($HEADER));

        curl_setopt($ch, CURLOPT_VERBOSE, true);
        // curl_setopt($ch, CURLOPT_STDERR, $fp);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);  //data
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);// request time out
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, '0'); // no ssl verifictaion
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, '0');


        $result=curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        Log::debug("Send To Bank ==>". print_r($result, true));

        //print_r($encBody);
//        print_r($result);
//        exit();


//        dd($result);

        if($httpcode == 200 || $httpcode ==201){
            $currentBal = UserBalance::where('user_id',auth()->user()->id)
                ->where('status',1)
                ->orderBy('id', 'desc')
                ->first();

            if (empty($currentBal)){
                $oldBal = 0;
            }else{
                $oldBal = $currentBal->balance;
            }

            $withdrawAmount =  -1 * abs($request->amount);

            $userBalance = new UserBalance();
            $userBalance->user_id = auth()->user()->id;
            $userBalance->amount =  $withdrawAmount;
            $userBalance->balance =  $oldBal + $withdrawAmount;
            $userBalance->saveOrFail();
            Session::flash('success', \GuzzleHttp\json_decode($result, true)['message']);

        }else{
            Session::flash('error', 'A fatal error occurred, please try again later');

        }




//        Session::flash("success", "Permission created successfully.");
        return redirect('withdraw');
    }
}
