@extends('layout')
@section('title', 'Delegation list')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mt-3">
                    <div class="card-header">{{ __('Delegation list for user : ') }}</div>
                    <div class="ms-auto me-auto mt-auto" style="width:500px;">
                        @csrf
                        <div class="form-group row">
                            <label for="form-title" class="col-md-4 col-form-label text-md-right">{{ __('User Id') }}</label>

                            <div class="mb-6">
                                <input type="text" class="form-control" id="form-userid" name="userid" autofocus=""
                                    required="required" minlength="32" maxlength="32" />
                                <span class="invalid-feedback" id="form-alert-userid" role="alert">
                                    <strong id="form-alert-text-userid"></strong>
                                </span>
                            </div>
                        </div>
                        <div class="form-group row mb-3 mt-3">
                            <div class="mb-6">
                                <button type="button" id="button-get-delegation-report"
                                    class="btn btn-primary">{{ __('Get list for user ID') }}</button>
                            </div>
                        </div>


                        <table class="table" id="delegation-list">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">{{ __('Start') }}</th>
                                    <th scope="col">{{ __('End') }}</th>
                                    <th scope="col">{{ __('CC') }}</th>
                                    <th scope="col">{{ __('A') }}</th>
                                    <th scope="col">{{ __('Cur.') }}</th>
                                </tr>
                            </thead>
                            <tbody id="delegation-list-body">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script src="{{ asset('page-js/delegation-list.js') }}"></script>
@endsection
