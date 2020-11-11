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
    <h3 class="card-title ftext-center">Reset your password</h3><br><br>
</div>
<div style="width: 65%;">
<form method="POST" action="{{ url('/password/sendemail') }}">
        @csrf
        <div class="input-group mb-3">
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email" autofocus>
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-envelope "></span>
                </div>
            </div>
            @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <button type="submit" class="btn btn-block btn-flat btn-primary">
            <span class="fas fa-share-square"></span>
            Send Password Reset Link
        </button>
         <a  href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><p
         style="margin-top: 1rem; text-align:center;">Back to Login</p>
        </a>
    </form>
     <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</div>
<div class=" ">
    
</div>


</div>
</div>
@endsection