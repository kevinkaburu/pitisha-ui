<?php

namespace App\Http\Controllers;

use App\Deposit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use ViewComponents\Eloquent\EloquentDataProvider;
use ViewComponents\Grids\Component\Column;
use ViewComponents\Grids\Component\ColumnSortingControl;
use ViewComponents\Grids\Component\CsvExport;
use ViewComponents\Grids\Component\PageTotalsRow;
use ViewComponents\Grids\Component\TableCaption;
use ViewComponents\Grids\Grid;
use ViewComponents\ViewComponents\Component\Control\FilterControl;
use ViewComponents\ViewComponents\Component\Control\PaginationControl;
use ViewComponents\ViewComponents\Customization\CssFrameworks\BootstrapStyling;
use ViewComponents\ViewComponents\Data\Operation\FilterOperation;
use ViewComponents\ViewComponents\Input\InputSource;

class DepositController extends Controller
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

        $deposits = Deposit::where('user_id', auth()->user()->id)->orderBy('id','desc')->paginate(20);


        return view('deposits/index', compact('deposits'));
    }

    public function deposit_mpesa(Request $request)
    {

        $this->validate($request, [
            'amount' => 'required'
        ]);



        $ENDPOINT = "http://127.0.0.1:8111/pitisha/mpesacheckout/";
        $HEADER = "Content-Type: application/json";


        $payload = array(
            "msisdn"=>auth()->user()->msisdn,
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

        Log::debug("STK PUSH ==>". print_r($result, true));


        if($httpcode == 200 || $httpcode ==201){
            return response()->json(['message' => "Please check your number to enter M-Pesa PIN"], 200, [], JSON_UNESCAPED_UNICODE);
        }else{
            return response()->json(['message' => "A system error occurred, please try again"], 500, [], JSON_UNESCAPED_UNICODE);
        }

    }
}
