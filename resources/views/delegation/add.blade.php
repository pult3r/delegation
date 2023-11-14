@extends('layout')
@section('title', 'Add delegation')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mt-3">
                    <div class="card-header">{{ __('Add delegation') }}</div>

                    <form action="" method="POST" class="ms-auto me-auto mt-auto" style="width:500px;"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="form-title"
                                class="col-md-4 col-form-label text-md-right">{{ __('User Id') }}</label>
                            <div class="mb-6">
                                <input type="text" class="form-control" id="form-userid" name="userid" autofocus=""
                                    required="" minlength="32" maxlength="32" />
                                <span class="invalid-feedback" id="form-alert-userid" role="alert">
                                    <strong id="form-alert-text-userid"></strong>
                                </span>
                            </div>
                        </div>

                        <div class="form-group row mb-3 mt-3">
                            <label for="form-title"
                                class="col-md-6 col-form-label text-md-right">{{ __('Don\'t have user id ?') }}</label>

                            <div class="mb-6">
                                <button type="button" id="button-get-auth-code"
                                    class="btn btn-primary">{{ __('Create your user ID') }}</button>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="form-title"
                                class="col-md-4 col-form-label text-md-right">{{ __('Country') }}</label>

                            <div class="mb-6">
                                <select class="form-control" id="form-countrycode" name="countrycode">
                                    @foreach ($countryRateList as $countryRate)
                                        <option value="{{ $countryRate->countrycode }}">{{ $countryRate->countrycode }} -
                                            {{ $countryRate->price }} {{ $countryRate->currency }}</option>
                                    @endforeach
                                </select>

                                <span class="invalid-feedback" id="form-alert-countrycode" role="alert">
                                    <strong id="form-alert-text-countrycode"></strong>
                                </span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="form-startdate"
                                class="col-md-4 col-form-label text-md-right">{{ __('Start date') }}</label>
                            <div class="mb-6">
                                <input type="date" placeholder="dd-mm-yyyy" class="form-control" id="form-startdate"
                                    name="startdate" required="" />
                                <span class="invalid-feedback" id="form-alert-startdate" role="alert">
                                    <strong id="form-alert-text-startdate"></strong>
                                </span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="form-starttime"
                                class="col-md-4 col-form-label text-md-right">{{ __('Start time') }}</label>
                            <div class="mb-6">
                                <input type="time" class="form-control" id="form-starttime" name="starttime"
                                    required="" />
                                <span class="invalid-feedback" id="form-alert-starttime" role="alert">
                                    <strong id="form-alert-text-starttime"></strong>
                                </span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="form-enddate"
                                class="col-md-4 col-form-label text-md-right">{{ __('End date') }}</label>
                            <div class="mb-6">
                                <input type="date" class="form-control" id="form-enddate" name="enddate"
                                    required="" />
                                <span class="invalid-feedback" id="form-alert-enddate" role="alert">
                                    <strong id="form-alert-text-enddate"></strong>
                                </span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="form-endtime"
                                class="col-md-4 col-form-label text-md-right">{{ __('End time') }}</label>
                            <div class="mb-6">
                                <input type="time" class="form-control" id="form-endtime" name="endtime"
                                    required="" />
                                <span class="invalid-feedback" id="form-alert-endtime" role="alert">
                                    <strong id="form-alert-text-endtime"></strong>
                                </span>
                            </div>
                        </div>

                        <div class="form-group row mb-3 mt-3">
                            <div class="mb-6">
                                <button type="button" id="button-add-delegation"
                                    class="btn btn-primary">{{ __('Add delegation') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script src="{{ asset('page-js/delegation-add.js') }}"></script>
@endsection
