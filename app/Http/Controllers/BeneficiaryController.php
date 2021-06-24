<?php

namespace App\Http\Controllers;

use App\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class BeneficiaryController extends Controller
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

        $accounts = Account::where('user_id', auth()->user()->id)->orderBy('id','desc')->paginate(20);

        return view('beneficiaries/index', compact('accounts'));
    }

    public function add_beneficiary(Request $request)
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

        if ($account->saveOrFail()){
            Session::flash('success', "Beneficiary added successfully");
        }

        return redirect('beneficiaries');
    }

}
