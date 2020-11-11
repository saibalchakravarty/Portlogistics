@extends('layouts.app')

@section('content')
<div class="row">
<div class="col-md-6 col-sm-12 loginbox-left-bar">
<div>
<h4 class="text-center">Welcome to</h4>
<h1 class="text-center"> Port Logistics</h1>
<h5 class="text-center">v1.0</h5>
</div>
<div class="app-user-brand">
<h2>Stevedores Ltd.</h2>
<h5>101,Infocity,Bhubaneswar</h5>
</div>
</div>
<div class="col-md-6 col-sm-12  loginbox-right-bar">

<div class=" ">
    <h3 class="card-title ftext-center">Sign in to start your session</h3><br><br>
</div>
<div style="width: 65%;">
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="input-group mb-3">
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                   value="{{ old('email') }}" placeholder="Email" autofocus>
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-envelope "></span>
                </div>
            </div>
            @error('email')
            <div class="invalid-feedback">
                <strong>{{ $message }}</strong>
            </div>
            @enderror
        </div>
        <div class="input-group mb-3">
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password"/>
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock "></span>
                </div>
            </div>
            @error('password')
            <div class="invalid-feedback">
                <strong>{{ $message }}</strong>
            </div>
            @enderror
        </div>
        <div class="row">
           
            <div class="col-12">
                <button type=submit class="btn btn-block btn-flat btn-primary">
                    <span class="fas fa-sign-in-alt"></span>&nbsp;{{ __('Sign In') }}
                </button>
            </div> 
            <div class="col-12">
                <!-- <div class="icheck-primary">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                           <label class="form-check-label" for="remember">{{ __('Remember Me') }}</label>
                </div> -->
                @if (Route::has('password.request'))

        <a  href="{{  route('password.request')  }}"><p
         style="margin-top: 1rem; text-align:center;">Forgot Password?</p>
        </a>
    
    @endif
            </div>
        </div>
    </form>
</div>
<div class=" ">
    
</div>


</div>
</div>
@endsection