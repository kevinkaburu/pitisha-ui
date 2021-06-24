@extends('layouts.app')

@section('content')
    <div class="content" style="margin-top: 0px">
        <div class="container-fluid">

            <br>
            <div class="container-fluid">
                <div class="card card-plain">
                    {{--<h6 style="margin-left: auto; margin-right: inherit; display: block; margin-top: auto; margin-bottom: auto;"> Download Transactions:  <a href="">PDF</a>&nbsp;&nbsp;<a href="#">CSV</a>&nbsp;</h6>--}}
                    {{--<br>--}}
                    {{--<div class="card-header card-header-info">--}}
                        {{--<form>--}}
                            {{--<div class="form-row align-items-center">--}}
                                {{--<div class="col-lg-3 col-md-6 col-sm-6" style="margin-left: auto; margin-right: auto; display: block; margin-top: auto; margin-bottom: auto;">--}}
                                    {{--<label class="mr-sm-2" for="inlineFormCustomSelect">Currency</label>--}}
                                    {{--<select class="custom-select mr-sm-2" id="inlineFormCustomSelect">--}}
                                        {{--<option selected>Choose...</option>--}}
                                        {{--<option value="1">USD</option>--}}
                                    {{--</select>--}}
                                {{--</div>--}}
                                {{--<div class="col-lg-3 col-md-6 col-sm-6" style="margin-left: auto; margin-right: auto; display: block; margin-top: auto; margin-bottom: auto;">--}}
                                    {{--<label class="mr-sm-2" for="inlineFormCustomSelect">Date Range</label>--}}
                                    {{--<select class="custom-select mr-sm-2" id="inlineFormCustomSelect">--}}
                                        {{--<option selected>Choose...</option>--}}
                                        {{--<option value="1">Last 30 Days</option>--}}
                                        {{--<option value="2">Last 60 Days</option>--}}
                                        {{--<option value="3">Last 90 Days</option>--}}
                                    {{--</select>--}}
                                {{--</div>--}}
                                {{--<div class="col-lg-3 col-md-6 col-sm-6" style="margin-left: auto; margin-right: auto; display: block; margin-top: auto; margin-bottom: auto;">--}}
                                    {{--<label class="mr-sm-2" for="inlineFormCustomSelect">Transaction Type</label>--}}
                                    {{--<select class="custom-select mr-sm-2" id="inlineFormCustomSelect">--}}
                                        {{--<option selected>Choose...</option>--}}
                                        {{--<option value="1">Sent</option>--}}
                                        {{--<option value="2">Received</option>--}}
                                        {{--<option value="3">Pending</option>--}}
                                    {{--</select>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</form>--}}
                    {{--</div>--}}
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="card">
                                <div class="card-header card-header-warning">
                                    <h4 class="card-title">Transactions</h4>
                                    <p class="card-category">Your most recent transactions appear here</p>
                                </div>
                                <div class="card-body table-responsive">
                                    <table class="table table-hover">
                                        <thead class="text-warning">
                                        <th>Date</th>
                                        <th>Type</th>
                                        <th>Amount</th>
                                        <th>Conf. Code</th>
                                        <th>Channel</th>
                                        </thead>
                                        <tbody>
                                        @foreach($transactions as $transaction)
                                            <tr>
                                                <td>
                                                    {{$transaction->created_at}}
                                                </td>
                                                {{--<td>--}}
                                                {{--<a href="{{url('/users/profile/'.($user->id))}}">{{$user->name}}</a>--}}
                                                {{--</td>--}}
                                                <td>{{$transaction->type}}</td>

                                                @if($transaction->type == "CREDIT")
                                                    <td>
                                                        Ksh. {{\App\Deposit::find($transaction->ref_id)->amount}}
                                                    </td>

                                                    <td>
                                                        {{\App\Deposit::find($transaction->ref_id)->confirmation_code}}
                                                    </td>

                                                    <td>
                                                        {{\App\Deposit::find($transaction->ref_id)->channel}}
                                                    </td>

                                                @elseif($transaction->type == "DEBIT")
                                                    <td>
                                                        Ksh. {{\App\Withdrawal::find($transaction->ref_id)->amount}}
                                                    </td>

                                                    <td>
                                                        {{\App\Withdrawal::find($transaction->ref_id)->confirmation_code}}
                                                    </td>

                                                    {{--<td>--}}
                                                    {{--{{\App\Deposit::find($transaction->ref_id)->channel}}--}}
                                                    {{--</td>--}}

                                                @endif

                                                {{--<td>--}}
                                                {{--<a href="javascript:void(0);" onclick="rm('{{$user->name}}','{{$user->id}}');">--}}
                                                {{--<span class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash"></span>--}}
                                                {{--&nbsp;Delete</span></a>--}}
                                                {{--</td>--}}
                                            </tr>
                                        @endforeach
                                        {{--<tr>--}}
                                        {{--<td>12-12-2018</td>--}}
                                        {{--<td>Ujuzi Group<br>--}}
                                        {{--<small>Payment</small></td>--}}
                                        {{--<td>Deposit</td>--}}
                                        {{--<td>USD</td>--}}
                                        {{--<td>$0.37</td>--}}
                                        {{--<td>$4.53</td>--}}
                                        {{--</tr>--}}
                                        </tbody>
                                    </table>
                                    {!! $transactions->render() !!}

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
@endsection
