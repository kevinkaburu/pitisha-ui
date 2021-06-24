@extends('layouts.app')

@section('content')
    <div class="content" style="margin-top: 0px">
        <div class="container-fluid">

            <br>
            <div class="row">
                <div class="col-md-8" style="margin-left:auto; margin-right:auto; display:block; margin-top:4%; margin-bottom:auto;">
                    <div class="card">
                        <div class="card-header card-header-warning">
                            <img src="{{url('dash/assets/img/pitisha-white.png')}}" />
                            <p class="card-category">Send Money to a Pitisha User</p>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Enter the recipient's details.</label>
                                            <input type="text" class="form-control" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-3">

                                    </div>
                                    <div class="col-md-4">

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">

                                    </div>
                                    <div class="col-md-6">

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Email Address</label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">

                                        <label for="validationDefaultUsername">Amount</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="inputGroupPrepend2">$</span>
                                            </div>
                                            <input type="text" class="form-control" id="validationDefaultUsername" placeholder="Amount(Digits only)" aria-describedby="inputGroupPrepend2" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">

                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary pull-right">Send</button>
                                <div class="clearfix"></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
