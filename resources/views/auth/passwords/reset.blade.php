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
<form method="POST" action="{{ url('/password/save') }}" onSubmit = "return checkPassword(this)">
        @csrf
        {{-- Token field --}}
        <input type="hidden" name="token" value="{{ $token }}">
        <div class="input-group mb-3">
            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" onkeypress="return event.charCode != 32" required>
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock "></span>
                </div>
            </div>
            @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="input-group mb-3">
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Retype password" onkeypress="return event.charCode != 32" required>
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock "></span>
                </div>
            </div>
            @error('password_confirmation')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <button type="submit" class="btn btn-block btn-flat btn-primary">
            <span class="fas fa-sync-alt"></span>
            Reset Password
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




 <script> 
          
            // Function to check Whether both passwords 
            // is same or not. 
            function checkPassword(form) { 
                password1 = form.password.value; 
                password2 = form.password_confirmation.value; 
  
                // If password not entered 
                if (password1 == '') 
                    alert ("Please enter Password"); 
                      
                // If confirm password not entered 
                else if (password2 == '') 
                    alert ("Please enter confirm password"); 
                      
                // If Not same return False.     
                else if (password1 != password2) { 
                    alert ("\nPassword did not match: Please try again...") 
                    return false; 
                } 
  
                // If same return True. 
                else{ 
                    return true; 
                } 
            } 
        </script>
@endsection
