@extends('layouts.app')

@section('content')
    <div class="content" style="margin-top: 0px">
        <div class="container-fluid">
            <br>
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header card-header-warning card-header-icon">
                            <div class="card-icon">
                                <i class="fa fa-university"></i>
                            </div>
                            <p class="card-category">Withdraw/Send to</p>
                            <h3 class="card-title">Any Bank</h3>
                        </div>
                        <div class="card-footer">
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#bankWithdraw"
                                    style="width: 10rem; margin-left:auto; margin-right:auto; display:block; margin-top:4%; margin-bottom:auto;">Withdraw</button>
                        </div>
                    </div>
                </div>
                {{--<div class="col-lg-4 col-md-6 col-sm-6">--}}
                    {{--<div class="card card-stats">--}}
                        {{--<div class="card-header card-header-danger card-header-icon">--}}
                            {{--<div class="card-icon">--}}
                                {{--<i class="material-icons">credit_card</i>--}}
                            {{--</div>--}}
                            {{--<p class="card-category">Withdraw to</p>--}}
                            {{--<h3 class="card-title">Credit &amp; Debit Card</h3>--}}
                        {{--</div>--}}
                        {{--<div class="card-footer">--}}
                            {{--<button type="button" class="btn btn-secondary" style="width: 10rem; margin-left:auto; margin-right:auto; display:block; margin-top:4%; margin-bottom:auto;;">Withdraw</button>--}}

                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header card-header-success card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">mobile_screen_share</i>
                            </div>
                            <p class="card-category">Withdraw/Send to</p>
                            <h3 class="card-title">Mobile Wallet</h3>
                        </div>
                        <div class="card-footer">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#mpesaWithdraw"
                                    style="width: 10rem; margin-left:auto; margin-right:auto; display:block; margin-top:4%; margin-bottom:auto;">Withdraw</button>

                        </div>
                    </div>
                </div>
            </div>

            @if (\Illuminate\Support\Facades\Session::has('message'))
                <div class="alert alert-info">{{ \Illuminate\Support\Facades\Session::get('message') }}</div>
            @endif
            @if (\Illuminate\Support\Facades\Session::has('error'))
                <div class="alert alert-danger">{{ \Illuminate\Support\Facades\Session::get('error') }}</div>
            @endif
            @if (\Illuminate\Support\Facades\Session::has('success'))
                <div class="alert alert-success">{{ \Illuminate\Support\Facades\Session::get('success') }}</div>
            @endif

            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="card">
                        <div class="card-header card-header-warning">
                            <h4 class="card-title">Recent Withdrawals</h4>
                            <p class="card-category">Your most recent withdrawal transactions appear here</p>
                        </div>
                        <div class="card-body table-responsive">
                            <table class="table table-hover">
                                <thead class="text-warning">
                                <th>Amount</th>
                                <th>Account No.</th>
                                <th>Account Name</th>
                                <th>Conf. Code</th>
                                <th>Status</th>
                                <th>Date</th>
                                </thead>
                                <tbody>
                                @foreach($withdrawals as $withdrawal)
                                    <tr>
                                        <td>
                                            {{$withdrawal->amount}}
                                        </td>
                                        {{--<td>--}}
                                        {{--<a href="{{url('/users/profile/'.($user->id))}}">{{$user->name}}</a>--}}
                                        {{--</td>--}}
                                        <td>{{optional($withdrawal->account)->account_number}}</td>
                                        <td>{{optional($withdrawal->account)->account_name}}</td>
                                        <td>{{$withdrawal->confirmation_code}}</td>
                                        <td>{{$withdrawal->status}}</td>
                                        <td>{{$withdrawal->created_at}}</td>
                                        {{--<td>--}}
                                        {{--<a href="javascript:void(0);" onclick="rm('{{$user->name}}','{{$user->id}}');">--}}
                                        {{--<span class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash"></span>--}}
                                        {{--&nbsp;Delete</span></a>--}}
                                        {{--</td>--}}
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {!! $withdrawals->render() !!}

                        </div>
                    </div>
                </div>
            </div>



        </div>
    </div>


    <!-- Modal -->
    <div id="mpesaWithdraw" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header" style="display: inline">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4  style="text-align: center;" class="modal-title">Withdraw to mobile money beneficiary</h4>
                </div>
                <div class="modal-body">
                    <div class="content">
                        <div class="container-fluid">
                            <div class="row">

                                <div class="col-md-12" style="margin-left:auto; margin-right:auto; display:block; margin-top:auto; margin-bottom:auto;">
                                    <form class="needs-validation" method="POST" action="{{ url('/withdraw/mobile') }}" novalidate style="margin-left:auto; margin-right:auto; display:block; margin-top:4%; margin-bottom:4%;">
                                        @csrf


                                        <div class="form-row">
                                            <div class="col">
                                                <label for="validationBank">Select Beneficiary</label>
                                                {!! Form::select('account_id', \App\Account::where('user_id', auth()->user()->id)->where('provider_id',1)->pluck('account_name', 'id'), null,
                                                  ['class' => 'form-control', 'id'=>'account_id','required']) !!}
                                                {{$errors->first("account_id") }}
                                            </div>
                                        </div>
                                        {{--<div class="form-row">--}}
                                        {{--<div class="col" >--}}
                                        {{--<label for="validationBankAc">Please make sure you have your registered phone number at hand; <strong>{{auth()->user()->msisdn}}</strong></label>--}}
                                        {{--</div>--}}
                                        {{--</div>--}}
                                        <br>
                                        <div class="form-row">
                                            <div class="col" >
                                                <label for="validationAmount">Amount (Ksh)</label>
                                                <div class="input-group">
                                                    {{--<div class="input-group-prepend">--}}
                                                    {{--<span class="input-group-text" id="validationTooltipAmountPrepend">Ksh. </span>--}}
                                                    {{--</div>--}}
                                                    <input type="number" min="0" name="amount" class="form-control" id="validationTooltipAmount" required>

                                                </div>
                                            </div>
                                        </div>

                                        <br>

                                        <button class="btn btn-primary" type="submit">Send</button>
                                    </form>
                                </div>

                            </div>


                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    {{--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>--}}
                </div>
            </div>

        </div>
    </div>


    <div id="bankWithdraw" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header" style="display: inline">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4  style="text-align: center;" class="modal-title">Withdraw to any bank in Kenya</h4>
                </div>
                <div class="modal-body">
                    <div class="content">
                        <div class="container-fluid">
                            <div class="row">

                                <div class="col-md-12" style="margin-left:auto; margin-right:auto; display:block; margin-top:auto; margin-bottom:auto;">
                                    <form class="needs-validation" method="POST" action="{{ url('/withdraw/bank') }}" novalidate style="margin-left:auto; margin-right:auto; display:block; margin-top:4%; margin-bottom:4%;">
                                        @csrf


                                        <div class="form-row">
                                            <div class="col">
                                                <label for="validationBank">Select Beneficiary</label>
                                                <select class="form-control" name="account_id" required>
                                                    @foreach(\App\Account::where('user_id', auth()->user()->id)->where('provider_id','!=',1)->get() as $account)
                                                        <option value="{{$account->id}}">{{$account->account_name}} - {{$account->provider->name}}</option>
                                                    @endforeach
                                                </select>
                                                {{$errors->first("account_id") }}
                                            </div>
                                        </div>

                                        <br>
                                        <div class="form-row">
                                            <div class="col" >
                                                <label for="validationAmount">Amount (Ksh)</label>
                                                <div class="input-group">
                                                    <input type="number" min="0" name="amount" class="form-control" id="validationTooltipAmount" required>

                                                </div>
                                            </div>
                                        </div>

                                        <br>

                                        <button class="btn btn-primary" type="submit">Send</button>
                                    </form>
                                </div>

                            </div>


                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    {{--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>--}}
                </div>
            </div>

        </div>
    </div>
@endsection
