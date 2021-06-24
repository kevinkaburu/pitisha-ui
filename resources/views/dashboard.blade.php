@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="container-fluid">

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




            @include('layouts.profile_progress')

            <div class="row">
                <div class="col-lg-8 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header card-header-warning card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">attach_money</i>
                            </div>
                            <p class="card-category">Available Balance</p>
                            <h3 class="card-title">Ksh. {{$bal}}</h3>
                        </div>
                        <div class="card-footer">
                            <table class="table">
                                <thead>
                                {{--<tr>--}}
                                    {{--<th scope="col">Flags</th>--}}
                                    {{--<th scope="col">Currency Name</th>--}}
                                    {{--<th scope="col">Amount</th>--}}
                                {{--</tr>--}}
                                </thead>
                                <tbody>
                                {{--<tr>--}}
                                    {{--<th scope="row">US</th>--}}
                                    {{--<td>US Dollar</td>--}}
                                    {{--<td>10</td>--}}
                                {{--</tr>--}}
                                {{--<tr>--}}
                                    {{--<th scope="row">KE</th>--}}
                                    {{--<td>Kenya Shillings</td>--}}
                                    {{--<td>100.00</td>--}}
                                {{--</tr>--}}
                                {{--<tr>--}}
                                    {{--<th scope="row">GB</th>--}}
                                    {{--<td>GB Pounds</td>--}}
                                    {{--<td>8.12</td>--}}
                                {{--</tr>--}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-actions">
                        <a href="{{url('deposit')}}" class="btn btn-primary"  style="width: 10rem; margin-left:auto; margin-right:auto; display:block; margin-top:4%; margin-bottom:auto;;">Deposit</a>
                        <br>
                        <a href="{{url('withdraw')}}" class="btn btn-secondary" style="width: 10rem; margin-left:auto; margin-right:auto; display:block; margin-top:auto; margin-bottom:4%;">Withdraw</a>

                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="card">
                        <div class="card-header card-header-warning">
                            <h4 class="card-title">Recent Transactions</h4>
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
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
