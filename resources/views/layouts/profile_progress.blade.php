<div class="row">
    <div class="card">
        <br>
        <p class="text-center"><strong>COMPLETE PROFILE</strong></p>
        <p class="text-center description">To be able to transact with Paypal, please complete our profile information.</p>
        <div class="inliner"></div>
        <div class="inlined">
            <!-- Start component -->
            <div class="progress-meter">
                <div class="track">
                    <span class="progress" style="width: {{$percentage}}%"></span>
                </div>
                <ol class="progress-points" >
                    <li class="progress-point {{is_null($emailVerified) ? '' : 'completed'}} ">
                        <span class="label">Email</span>
                    </li>
                        @if(is_null($phoneVerified) && $percentage == 25)
                            <li  data-toggle="modal" data-target="#verifyMobile" class="progress-point {{is_null($phoneVerified) ? '' : 'completed'}} ">
                                <span class="label">Phone</span>
                            </li>
                        @else
                        <li class="progress-point {{is_null($phoneVerified) ? '' : 'completed'}} ">
                            <span class="label">Phone</span>
                        </li>
                        @endif

                        @if(is_null($userIdentity) && $percentage == 50)
                            <li data-toggle="modal" data-target="#addIdentity" class="progress-point {{is_null($userIdentity) ? '' : 'completed'}} ">
                                <span class="label">Identity</span>
                            </li>
                        @else
                            <li class="progress-point {{is_null($userIdentity) ? '' : 'completed'}} ">
                                <span class="label">Identity</span>
                            </li>
                        @endif


                        @if(is_null($userBank) && $percentage == 75)
                            <li data-toggle="modal" data-target="#addBankDetails" class="progress-point {{is_null($userBank) ? '' : 'completed'}} ">
                                <span class="label">Bank</span>
                            </li>
                        @else
                            <li class="progress-point {{is_null($userBank) ? '' : 'completed'}} ">
                                <span class="label">Bank</span>
                            </li>
                        @endif


                        @if(is_null($userAddress) && $percentage == 100)
                            <li data-toggle="modal" data-target="#target" class="progress-point {{is_null($userAddress) ? '' : 'completed'}} ">
                                <span class="label">Address</span>
                            </li>
                        @else
                            <li class="progress-point {{is_null($userAddress) ? '' : 'completed'}} ">
                                <span class="label">Address</span>
                            </li>
                        @endif
                </ol>
            </div>
        </div>
    </div>
</div>


<div id="verifyMobile" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header" style="display: inline">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4  style="text-align: center;" class="modal-title">Verify Phone number</h4>
            </div>
            <div class="modal-body">
                <div class="content">
                    <div class="container-fluid">
                        <div class="row">

                            <div class="col-md-12" style="margin-left:auto; margin-right:auto; display:block; margin-top:auto; margin-bottom:auto;">

                                <div id="form-messages"></div>

                                <div class="form-row">
                                    <div class="col" >
                                        <label for="validationBankAc">Click "send" to receive an OTP to your phone number <strong>{{auth()->user()->msisdn}}</strong> for verification</label>
                                        <button onclick="verify_phone()" class="btn btn-success" >Send verification code</button>
                                        <div id="progress-cogs" style="color: green; display: none" class="fa fa-cog fa-spin fa-lg"></div>
                                        <div id="form-messages"></div>

                                    </div>
                                </div>

                                <form class="needs-validation" method="POST" id="mpesa-form" action="{{ url('/user/sms/verify_otp') }}" novalidate style="margin-left:auto; margin-right:auto; display:block; margin-top:4%; margin-bottom:4%;">
                                    @csrf

                                    <br>

                                    <br>
                                    <div class="form-row">
                                        <div class="col" >
                                            <label for="validationAmount">Enter the OTP received below to verify your phone number</label>
                                            <div class="input-group">
                                                <input type="number" name="otp" min="0" class="form-control" id="otp" placeholder="Enter OTP received" required>
                                            </div>
                                        </div>
                                    </div>
                                    <br>

                                    <button class="btn btn-primary" type="submit">Verify</button>
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


<div id="addBankDetails" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header" style="display: inline">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4  style="text-align: center;" class="modal-title">Add account details</h4>
            </div>
            <div class="modal-body">
                <div class="content">
                    <div class="container-fluid">
                        <div class="row">

                            <div class="col-md-12" style="margin-left:auto; margin-right:auto; display:block; margin-top:auto; margin-bottom:auto;">
                                <form class="needs-validation" method="POST" action="{{ url('/user/accounts/add') }}" novalidate style="margin-left:auto; margin-right:auto; display:block; margin-top:4%; margin-bottom:4%;">
                                    @csrf


                                    <div class="form-row">
                                        <div class="col">
                                            <label for="validationBank">Select Bank</label>
                                            <select class="form-control" name="provider_id" required>
                                                @foreach(\App\Provider::where('id','!=',1)->get() as $provider)
                                                    <option value="{{$provider->id}}">{{$provider->name}}</option>
                                                @endforeach
                                            </select>
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
                                            <label for="validationAmount">Account Number Number</label>
                                            <div class="input-group">
                                                {{--<div class="input-group-prepend">--}}
                                                {{--<span class="input-group-text" id="validationTooltipAmountPrepend">Ksh. </span>--}}
                                                {{--</div>--}}
                                                <input type="text"  name="account_number" class="form-control" id="validationTooltipAmount" required>

                                            </div>
                                        </div>
                                    </div>
                                    <br>

                                    <button class="btn btn-primary" type="submit">Add</button>
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


<div id="addIdentity" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header" style="display: inline">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4  style="text-align: center;" class="modal-title">Confirm your identity</h4>
            </div>
            <div class="modal-body">
                <div class="content">
                    <div class="container-fluid">
                        <div class="row">

                            <div class="col-md-12" style="margin-left:auto; margin-right:auto; display:block; margin-top:auto; margin-bottom:auto;">
                                <form class="needs-validation" method="POST" action="{{ url('/user/identity/add') }}" enctype="multipart/form-data" novalidate style="margin-left:auto; margin-right:auto; display:block; margin-top:4%; margin-bottom:4%;">
                                    @csrf

                                    <br>
                                    <div class="form-row">
                                        <div class="col" >
                                            <label for="validationAmount">Nationality</label>
                                            <div class="input-group">
                                                <input type="text" name="nationality" class="form-control" id="validationTooltipAmount" required>

                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="form-row">
                                        <div class="col" >
                                            <label for="validationAmount">Identification Number</label>
                                            <div class="input-group">
                                                <input type="text"  name="id_number" class="form-control" id="validationTooltipAmount" required>

                                            </div>
                                        </div>
                                    </div>
                                    <br>

                                    <div class="form-row">
                                        <div class="col" >
                                            <label for="validationAmount">Identification File</label>
                                            <div class="input-group">
                                                <input type="file"  name="id_file" class="form-control"  required>
                                            </div>
                                            <ul>
                                                <li>Accepted formats: jpg, jpeg, png and pdf</li>
                                                <li>Maximum size per file: 5MB</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <br>

                                    <button class="btn btn-primary" type="submit">Add</button>
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

@section('scripts')
    <script>

        var formMessages = $('#form-messages');
        var progressCogs = $('#progress-cogs');

        // $(document).ready(function () {
        //
        //     progressCogs.style.display = "none";
        // });


        function verify_phone(){

            progressCogs.show();


            $.ajax({
                url: '/user/sms/send_otp/' ,
                type: 'get',
                headers: {
                    'X-XSRF-Token': $('meta[name="_token"]').attr('content')
                },
                success: function (response) {
                    response = JSON.parse(response);
                    progressCogs.hide();

                    if (response.error) {
                        $(formMessages).removeClass('alert-success');
                        $(formMessages).addClass('alert');
                        $(formMessages).addClass('alert-danger');
                        $(formMessages).text(response.message);
                    } else {
                        // Make sure that the formMessages div has the 'success' class.
                        $(formMessages).removeClass('alert-danger');
                        $(formMessages).addClass('alert');
                        $(formMessages).addClass('alert-success');

                        // Set the message text.
                        $(formMessages).text(response.message);

                    }
                },
                error: function (request, status, error) {
                    progressCogs.hide();

                    $(formMessages).removeClass('alert-success');
                    $(formMessages).addClass('alert');
                    $(formMessages).addClass('alert-danger');

                    $(formMessages).text('Oops! A system error occurred, please try again');
                }
            });
        }



    </script>
@endsection
