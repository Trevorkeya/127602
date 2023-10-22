@extends('layouts.app') 

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">{{ __('Two-Factor Authentication Verification') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('2fa.verify') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="2fa_code" class="form-label">{{ __('Enter your 2FA code') }}</label>
                                <input type="text" id="2fa_code" name="2fa_code" class="form-control @error('2fa_code') is-invalid @enderror" required>
                                @error('2fa_code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">{{ __('Verify') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
