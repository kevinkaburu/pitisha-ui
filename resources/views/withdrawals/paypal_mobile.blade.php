@extends('layouts.app')

@section('content')
    <div class="content" style="margin-top: 0px">
        <div class="container-fluid">

            <br>

            @if(is_null($phoneVerified))
                @include('layouts.profile_progress')
            @endif

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
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header card-header-success card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">mobile_screen_share</i>
                            </div>
                            <p class="card-category">PayPal to</p>
                            <h3 class="card-title">Mobile Wallet</h3>
                        </div>
                        <div class="card-footer">
                            @if(is_null($phoneVerified))
                                <div style="text-align: center;">
                                    <div class="alert alert-info">Please verify your phone number to withdraw from PayPal to M-Pesa</div>
                                </div>
                            @else
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#withdrawMobile"
                                        style="width: 10rem; margin-left:auto; margin-right:auto; display:block; margin-top:4%; margin-bottom:auto;">Withdraw</button>
                            @endif

                        </div>
                    </div>
                </div>
            </div>



        </div>
    </div>

    <!-- Modal -->

    <div id="withdrawMobile" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header" style="display: inline">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4  style="text-align: center;" class="modal-title">Withdraw from Paypal to your M-Pesa</h4>
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
                                                        <input type="number" min="1" class="form-control" id="amount" placeholder="Amount"
                                                               aria-describedby="validationTooltipAmountPrepend" name="amount"  required>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div style="color: red">
                                                You will receive Ksh. <span id="receive-amount"></span>
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
                url: '/withdraw/paypal/mobile/verify/' + orderID,
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

        $(document).ready(function(){
            var $receiveAmount = $( "#receive-amount" );
            var $amount = $('#amount');
            var $rate = '{{\App\Forex::where('status',1)->orderBy('forex_id','desc')->first()->usd_rate()}}';

            $amount.on('change', function(){
                $receiveAmount.text($rate*$amount.val());
            });
        });


    </script>
@endsection

