<!-- Navbar -->
<nav class="header">
    <!-- Left navbar links -->
    <div class="d-flex justify-content-center align-items-center w-100">
        <div class="col-md-3 col-sm-12 d-flex justify-content-start align-items-center">
            <a class="menu-btn" data-widget="pushmenu" href="#" role="button">
            <i class="fa fa-th" aria-hidden="true"></i>
            </a>

            <img src="{{images('logo')}}" alt="Port Logistic Logo" class="">

        </div>
        <div class="col-md-6 col-sm-12 d-flex justify-content-center align-items-center">
            
            <h4>{{ isset(Auth::user()->organization->name) && !empty(Auth::user()->organization->name)?Auth::user()->organization->name:"" }}</h4> 
        </div>
        <div class="col-md-3 col-sm-12 d-flex justify-content-end align-items-center">
            
        <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a id="navbarDropdown" class="username-bar dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
            <div style="width:auto">
                <img alt="User Image" class="user-image" src="{{(Auth::user()->image_path)? asset('storage/'.Auth::user()->image_path) : images('default_profile_photo')}}"  ></div>
            <div style="width:auto">
            <span class="username">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}<br>{{Auth::user()->department->name}}</span> 
                <span class="caret"></span>
            </div>
            </a>

            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="{{ url('/profile') }}">
                    {{ __('My Profile') }}
                </a>
                <a class="dropdown-item" href="{{ url('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>
                <form id="logout-form" action="{{ url('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </li>
    </ul>
        </div>
    
    
    
    </div>
     
            
    
         
    
       
    <!-- Right navbar links -->

</nav>
<!-- /.navbar -->