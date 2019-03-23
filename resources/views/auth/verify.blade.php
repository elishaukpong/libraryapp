@extends('layouts.app')

@section('content')
<div class="jumbotron text-center my-4">
    <h1>Verify Email</h1>
</div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body text-center">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    <p>{{ __('Before proceeding, please check your email for a verification link.') }} <br>
                    {{ __('If you did not receive the email') }}</p>

                    <a href="{{ route('verification.resend') }}" class="btn btn-success">{{ __('click here to request another') }}</a>.
                </div>
            </div>
        </div>
    </div>
@endsection
