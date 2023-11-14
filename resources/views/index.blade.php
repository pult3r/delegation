@extends('layout')
@section('title', 'Home Page')
@section('content')
    <div class="container">
        <div class="row  justify-content-center align-items-center d-flex  h-100 mt-5">
            <div class="col-12 col-md-12   ">
                <h1 class="   mb-2  "><strong>{{ __('Welcome to Delegation report system') }}</strong> </h1>
                <p class="lead font-weight-bold  mb-5 pb-5 border-bottom border-grey">
                    {{ __('Here you can add and check your delegation') }}</p>
                <div class="row">
                    <div class="col-lg-4 mb-5 mb-lg-0">
                        <div class="  text-danger mb-3">
                            <i class="fab fa-grav fa-2x"></i>
                        </div>
                        <h4 class="h5 mb-4">{{ __('Add delegation') }}</h4>
                        <p>{{ __('You can add here your delegation. Just click "Add delegation" on the top navi bar') }}</p>
                    </div>

                    <div class="col-lg-4 mb-5 mb-lg-0">
                        <div class="  text-danger mb-3">
                            <i class="fab fa-connectdevelop  fa-2x"></i>
                        </div>
                        <h4 class="h5 mb-4">{{ __('Check your delegation list') }}</h4>
                        <p>{{ __('You can check here your delegation report. Just click "Delegation list" on the top navi bar') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    <script src="{{ asset('page-js/postlist.js') }}"></script>
@endsection
