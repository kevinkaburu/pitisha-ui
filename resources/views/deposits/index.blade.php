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
                            <p class="card-category">Deposit from</p>
                            <h3 class="card-title">Mobile Wallet</h3>
                        </div>
                        <div class="card-footer">
                            {{--<button type="button" class="btn btn-primary" onclick="window.location='./deposit-mobilewallet.html';"
                             style="width: 10rem; margin-left:auto; margin-right:auto; display:block; margin-top:4%; margin-bottom:auto;">Deposit</button>--}}
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#depositMobile"
                                    style="width: 10rem; margin-left:auto; margin-right:auto; display:block; margin-top:4%; margin-bottom:auto;">Deposit</button>
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
                            <h4 class="card-title">Recent Deposits</h4>
                            <p class="card-category">Your most recent deposit transactions appear here</p>
                        </div>
                        <div class="card-body table-responsive">
                            <table class="table table-hover">
                                <thead class="text-warning">
                                <th>Amount (Ksh.)</th>
                                <th>Channel</th>
                                <th>Confirmation Code</th>
                                <th>Date</th>
                                </thead>
                                <tbody>
                                @foreach($deposits as $deposit)
                                    <tr>
                                        <td>
                                            {{$deposit->amount}}
                                        </td>
                                        {{--<td>--}}
                                            {{--<a href="{{url('/users/profile/'.($user->id))}}">{{$user->name}}</a>--}}
                                        {{--</td>--}}
                                        <td>{{$deposit->channel}}</td>
                                        <td>{{$deposit->confirmation_code}}</td>
                                        <td>{{$deposit->created_at}}</td>
                                        {{--<td>--}}
                                            {{--<a href="javascript:void(0);" onclick="rm('{{$user->name}}','{{$user->id}}');">--}}
                                                        {{--<span class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash"></span>--}}
                                                        {{--&nbsp;Delete</span></a>--}}
                                        {{--</td>--}}
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {!! $deposits->render() !!}

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Modal -->
    <div id="depositMobile" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header" style="display: inline">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4  style="text-align: center;" class="modal-title">Deposit from mobile money</h4>
                </div>
                <div class="modal-body">
                    <div class="content">
                        <div class="container-fluid">
                            <div class="row">

                                <div class="col-md-12" style="margin-left:auto; margin-right:auto; display:block; margin-top:auto; margin-bottom:auto;">

                                    <div id="form-messages"></div>

                                    <form class="needs-validation" method="POST" id="mpesa-form" action="{{ url('/deposit/mpesa') }}" novalidate style="margin-left:auto; margin-right:auto; display:block; margin-top:4%; margin-bottom:4%;">
                                            @csrf

                                            {{--<div class="form-row">--}}
                                                {{--<div class="col">--}}
                                                    {{--<label for="validationBank">Select your Phone Operator</label>--}}
                                                    {{--<select class="custom-select">--}}
                                                        {{--<option selected>Choose your Operator</option>--}}
                                                        {{--<option value="1">Safaricom -  MPESA</option>--}}
                                                        {{--<option value="2">Airtel - Airtel Money</option>--}}
                                                        {{--<option value="3">Equitel</option>--}}
                                                    {{--</select>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                            <br>
                                            <div class="form-row">
                                                <div class="col" >
                                                    <label for="validationBankAc">Please make sure you have your registered phone number at hand; <strong>{{auth()->user()->msisdn}}</strong></label>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="form-row">
                                                <div class="col" >
                                                    <label for="validationAmount">Enter the Amount</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="validationTooltipAmountPrepend">Ksh. </span>
                                                        </div>
                                                        <input type="number" name="amount" min="0" class="form-control" id="amount" placeholder="Amount" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>

                                            <button class="btn btn-primary" type="submit">Deposit</button>
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

    <div id="depositPaypal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header" style="display: inline">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4  style="text-align: center;" class="modal-title">Deposit from Paypal and Debit/credit cards</h4>
                </div>
                <div class="modal-body">
                    <div class="content">
                        <div class="container-fluid">

                            <div class="row">
                                <div class="col-md-8" style="margin-left:auto; margin-right:auto; display:block; margin-top:auto; margin-bottom:auto;">
                                    <div class="card">
                                        <form name="payform" class="needs-validation" novalidate style="margin-left:auto; margin-right:auto; display:block; margin-top:4%; margin-bottom:4%;">
                                            <br>
                                            <div class="form-row">
                                                <div class="col" >
                                                    <label for="validationAmount">Enter the Amount (USD)</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="validationTooltipAmountPrepend">USD </span>
                                                        </div>
                                                        <input type="number" min="1" class="form-control" id="validationTooltipAmount" placeholder="Amount"
                                                               aria-describedby="validationTooltipAmountPrepend" name="amount" required>
                                                        <div class="invalid-feedback">
                                                            Use the digits only
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>

                                            <div id="paypal-button-container"></div>

                                        </form>
                                    </div>
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
    <script src="https://www.paypal.com/sdk/js?client-id=AeJcD0QwLDMAQZH5HHNDfJBKvIxDMd0SWKca3rrX3IdhK62xLu0EInhkOScSskKtxVhNBjroPkIX0Oeu&currency=USD"></script>
    <script>
        // paypal.Buttons().render('#paypal-button-container');
        paypal.Buttons({
            createOrder: function(data, actions) {
                // Set up the transaction
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: payform.amount.value
                        },
                        custom_id: "{{auth()->user()->id}}"
                    }]
                });
            },
            onApprove: function(data, actions) {
            // Capture the funds from the transaction
            return actions.order.capture().then(function(details) {
                // Show a success message to your buyer
                showReceived(details.payer.name.given_name);
                // alert('Transaction completed by ' + details.payer.name.given_name);
                console.log("order id",data.orderID );
                verify_payment(data.orderID);
                // return fetch('/paypal/payment/verify', {
                //     method: 'post',
                //     body: JSON.stringify({
                //         orderID: data.orderID
                //     })
                // });
            });
        },
            style: {
                color:  'blue',
                shape:  'pill',
                label:  'pay'
            }}).render('#paypal-button-container');


        function verify_payment(orderID){
            $.ajax({
                url: '/paypal/payment/verify/' + orderID,
                type: 'get',
                headers: {
                    'X-XSRF-Token': $('meta[name="_token"]').attr('content')
                },
                success: function (html) {
                    location.reload();
                }
            });
        }




        function showReceived(name) {
            swal({
                title: 'Transaction received!',
                text: "Transaction completed by ".name,
                type: 'success',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Great!'
            },function() {
               // location.reload();

            });
        }


        var form = $('#mpesa-form');
        var formMessages = $('#form-messages');

        // Set up an event listener for the contact form.
        $(form).submit(function(event) {
            // Stop the browser from submitting the form.
            event.preventDefault();

            var formData = $(form).serialize();

            $.ajax({
                type: 'POST',
                url: $(form).attr('action'),
                data: formData
            }).done(function(response) {
                // Make sure that the formMessages div has the 'success' class.
                $(formMessages).removeClass('alert-danger');
                $(formMessages).addClass('alert');
                $(formMessages).addClass('alert-success');

                // Set the message text.
                $(formMessages).text(response['message']);

                // Clear the form.
                $('#amount').val('');
            }).fail(function(data) {
                // Make sure that the formMessages div has the 'error' class.
                $(formMessages).removeClass('alert-success');
                $(formMessages).addClass('alert');
                $(formMessages).addClass('alert-danger');

                // Set the message text.
                // if (data.responseText !== '') {
                //     $(formMessages).text(data.responseText);
                // } else {
                    $(formMessages).text('Oops! A system error occurred, please try again');
                    $('#amount').val('');
                // }
            });

            // TODO
        });



    </script>
@endsection

