@extends('layouts.app')

@section('content')
    <div class="content" style="margin-top: 0px">
        <div class="container-fluid">

            <br>
            <div class="row">
                <div class="col-md-8" style="margin-left:auto; margin-right:auto; display:block; margin-top:4%; margin-bottom:auto;">
                    <div class="card">
                        <div class="card-body" style="margin-left:auto; margin-right:auto; display:block; margin-top:10%; margin-bottom:10%;">
                            <i class="material-icons" style="font-size: 50px; margin-left: 38%;">check_circle</i>
                            <h3><strong>You Have No Cases!<strong></h3>
                            <a class="btn btn-primary" href="#" role="button" style="margin-left:auto; margin-right:auto; display:block; margin-top:auto; margin-bottom:auto;">Create Case</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
