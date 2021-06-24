<?php

namespace App\Http\Controllers;

use AfricasTalking\SDK\AfricasTalking;
use App\Account;
use App\OTP;
use App\UserBank;
use App\UserDetails;
use App\UserMobileAccount;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class SettingsController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('settings/index');
    }

    public function send_otp()
    {

        $username = 'pitisha'; // use 'sandbox' for development in the test environment
        $apiKey   = '29bba6c61db3c25f2360bcebd4ff1c80c12ae94bd3ca6f12242582d1da9751de'; // use your sandbox app API key for development in the test environment
        $AT       = new AfricasTalking($username, $apiKey);
        // Get one of the services
        $sms      = $AT->sms();

        $otp_code = rand(1000,9999);

        $otp = new OTP();
        $otp->msisdn = auth()->user()->msisdn;
        $otp->otp = $otp_code;


        $otp = OTP::updateOrCreate(
            ['msisdn' => auth()->user()->msisdn],
            ['otp' => $otp_code, 'used' => 0]
        );

            // Use the service
            $result   = $sms->send([
                'to'      => auth()->user()->msisdn,
                'message' => 'Hello, please use this code af your OTP for Pitisha verification: '.$otp_code
            ]);

            Log::debug("Africastalking send OTP ==>". print_r($result, true));
            return json_encode(["error" => false, "message" => "OTP has been sent successfully. Please check your phone"]);


    }


    public function verify_otp(Request $request)
    {

        $this->validate($request, [
            'otp' => 'required'
        ]);

        $otp = OTP::where('msisdn',auth()->user()->msisdn)->first();

        if (is_null($otp)){
            Session::flash('error', "Invalid OTP, please generate another OTP code");
            return redirect()->back();

        }else{
            if ($otp->otp == $request->otp){
                if ($otp->used == 1){
                    Session::flash('error', "Your OTP code has expired, please generate a new one");
                    return redirect()->back();
                }else{
                    DB::transaction(function () use ($otp){

                        $otp->used = 1;
                        $otp->update();

                        $account = new Account();
                        $account->user_id = auth()->user()->id;
                        $account->account_name = auth()->user()->name;
                        $account->account_number = auth()->user()->msisdn;
                        $account->provider_id = 1;

                        if ($account->saveOrFail()){
                            $userModileAccount = new UserMobileAccount();
                            $userModileAccount->user_id = auth()->user()->id;
                            $userModileAccount->account_id = $account->id;
                            $userModileAccount->saveOrFail();
                        }

                        $user = auth()->user();
                        $user->phone_verified_at = Carbon::now();
                        $user->update();

                        Session::flash('success', "Your phone number has been verified successfully");

                    });
                }

            }else{
                Session::flash('error', "You entered an Invalid OTP code");
                return redirect()->back();
            }
        }

        return redirect()->back();

    }

    public function add_account(Request $request)
    {

        $this->validate($request, [
            'provider_id' => 'required',
            'account_name' => 'required',
            'account_number' => 'required'
        ]);

        $account = new Account();
        $account->user_id = auth()->user()->id;
        $account->account_name = $request->account_name;
        $account->account_number = $request->account_number;
        $account->provider_id = $request->provider_id;


        DB::transaction(function () use ($account){

            if ($account->saveOrFail()){

                $userBank = new UserBank();
                $userBank->user_id = auth()->user()->id;
                $userBank->account_id = $account->id;

                if ($userBank->saveOrFail()){
                    Session::flash('success', "Account added successfully");
                }
            }

        });

        return redirect()->back();
    }

    public function add_identity(Request $request)
    {

        $this->validate($request, [
            'nationality' => 'required',
            'id_number' => 'required',
            'id_file' => 'file|max:5000',
        ]);

        $userDetails = new UserDetails();
        $userDetails->user_id = auth()->user()->id;
        $userDetails->nationality = $request->nationality;
        $userDetails->id_number = $request->id_number;



        DB::transaction(function () use ($userDetails,$request){

            if ($request->hasFile('id_file')) {

                $file = $request->file('id_file');
                $destinationPath = 'uploads';

                if ($file->move($destinationPath,auth()->user()->id.'-'.auth()->user()->name.'-'.$file->getClientOriginalName())){
                    $userDetails->identification_link = 'uploads/'.auth()->user()->id.'-'.auth()->user()->name.'-'.$file->getClientOriginalName();
                    $userDetails->saveOrFail();
                    Session::flash('success', "Identity uploaded successfully");

                }else{
                    Session::flash('error', "An error occurred when uploading the file, please try again");
                }

            }else{
                Session::flash('error', "Unable to upload file, please try again");

            }

        });

        return redirect()->back();
    }
}
