@extends('layouts.app')

@section('content')
    <div class="content" style="margin-top: 0px">
        <div class="container-fluid">

            <br>
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header card-header-success card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">mobile_screen_share</i>
                            </div>
                            <p class="card-category">Manage your</p>
                            <h3 class="card-title">Beneficiaries</h3>
                        </div>
                        <div class="card-footer">
                            {{--<button type="button" class="btn btn-primary" onclick="window.location='./deposit-mobilewallet.html';"
                             style="width: 10rem; margin-left:auto; margin-right:auto; display:block; margin-top:4%; margin-bottom:auto;">Deposit</button>--}}
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addBeneficiary"
                                    style="width: 10rem; margin-left:auto; margin-right:auto; display:block; margin-top:4%; margin-bottom:auto;">Add Beneficiary</button>
                        </div>
                    </div>
                </div>
                {{--<div class="col-lg-4 col-md-6 col-sm-6">--}}
                    {{--<div class="card card-stats">--}}
                        {{--<div class="card-header card-header-danger card-header-icon">--}}
                            {{--<div class="card-icon">--}}
                                {{--<i class="material-icons">credit_card</i>--}}
                            {{--</div>--}}
                            {{--<p class="card-category">Deposit from</p>--}}
                            {{--<h3 class="card-title">Credit &amp; Debit Card</h3>--}}
                        {{--</div>--}}
                        {{--<div class="card-footer">--}}
                            {{--<button type="button" class="btn btn-primary" onclick="window.location='./deposit-card.html';" style="width: 10rem; margin-left:auto; margin-right:auto; display:block; margin-top:4%; margin-bottom:auto;s">Deposit</button>--}}

                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="col-lg-4 col-md-6 col-sm-6">--}}
                    {{--<div class="card card-stats">--}}
                        {{--<div class="card-header card-header-warning card-header-icon">--}}
                            {{--<div class="card-icon">--}}
                                {{--<i class="fa fa-paypal"></i>--}}
                            {{--</div>--}}
                            {{--<p class="card-category">Deposit from</p>--}}
                            {{--<h3 class="card-title">Paypal</h3>--}}
                        {{--</div>--}}
                        {{--<div class="card-footer">--}}
                            {{--<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#depositPaypal"--}}
                                    {{--style="width: 10rem; margin-left:auto; margin-right:auto; display:block; margin-top:4%; margin-bottom:auto;">Deposit</button>--}}

                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
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
                            <h4 class="card-title">Beneficiaries</h4>
                            <p class="card-category">Your Pitisha Beneficiaries/Recipients</p>
                        </div>
                        <div class="card-body table-responsive">
                            <table class="table table-hover">
                                <thead class="text-warning">
                                <th>Name</th>
                                <th>Account No.</th>
                                <th>Provider</th>
                                <th>Type</th>
                                <th>Created</th>
                                {{--<th></th>--}}
                                </thead>
                                <tbody>
                                @foreach($accounts as $account)
                                    <tr>
                                        <td>
                                            {{$account->account_name}}
                                        </td>
                                        {{--<td>--}}
                                            {{--<a href="{{url('/users/profile/'.($user->id))}}">{{$user->name}}</a>--}}
                                        {{--</td>--}}
                                        <td>{{$account->account_number}}</td>
                                        <td>{{$account->provider->name}}</td>
                                        <td>{{$account->provider->type}}</td>
                                        <td>{{$account->created_at}}</td>
                                        {{--<td>--}}
                                            {{--<a href="javascript:void(0);" onclick="rm('{{$account->account_name}}','{{$account->id}}');">--}}
                                                        {{--<span class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash"></span>--}}
                                                        {{--&nbsp;Delete</span></a>--}}
                                        {{--</td>--}}
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {!! $accounts->render() !!}

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Modal -->
    <div id="addBeneficiary" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header" style="display: inline">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4  style="text-align: center;" class="modal-title">Add new beneficiary</h4>
                </div>
                <div class="modal-body">
                    <div class="content">
                        <div class="container-fluid">
                            <div class="row">

                                <div class="col-md-12" style="margin-left:auto; margin-right:auto; display:block; margin-top:auto; margin-bottom:auto;">
                                        <form class="needs-validation" method="POST" action="{{ url('/beneficiaries/add') }}" novalidate style="margin-left:auto; margin-right:auto; display:block; margin-top:4%; margin-bottom:4%;">
                                            @csrf


                                            <div class="form-row">
                                                <div class="col">
                                                    <label for="validationBank">Select Provider</label>
                                                    {!! Form::select('provider_id', \App\Provider::pluck('name', 'id'), null,
                                                      ['class' => 'form-control', 'id'=>'provider_id','required']) !!}
                                                    {{$errors->first("provider_id") }}
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
                                                    <label for="validationAmount">Account Name</label>
                                                    <div class="input-group">
                                                        {{--<div class="input-group-prepend">--}}
                                                            {{--<span class="input-group-text" id="validationTooltipAmountPrepend">Ksh. </span>--}}
                                                        {{--</div>--}}
                                                        <input type="text" name="account_name" class="form-control" id="validationTooltipAmount" required>

                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="form-row">
                                                <div class="col" >
                                                    <label for="validationAmount">Account Number/M-Pesa Number</label>
                                                    <div class="input-group">
                                                        {{--<div class="input-group-prepend">--}}
                                                            {{--<span class="input-group-text" id="validationTooltipAmountPrepend">Ksh. </span>--}}
                                                        {{--</div>--}}
                                                        <input type="text"  name="account_number" class="form-control" id="validationTooltipAmount" required>

                                                    </div>
                                                </div>
                                            </div>
                                            <br>

                                            <button class="btn btn-primary" type="submit">Create</button>
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

@section('scripts')

@endsection

