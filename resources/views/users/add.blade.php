@extends('layouts.layout')

@section('content')
<?php
    $data = $result;
    $action = (isset($data['user']) && !empty($data['user'])) ? 'Edit' : 'Add';
?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">{{$action}} User</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Administration</a></li>
                        <li class="breadcrumb-item"><a href="{{url('users')}}">Users</a></li>
                        <li class="breadcrumb-item active">{{$action}} User</li>
                    </ol>
                </div>
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <form id="addUserForm" novalidate="novalidate">
                            <input type="hidden" name="id" id="id" value="{{isset($data['user']->id) && !empty($data['user']->id) ? $data['user']->id : ''}}">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="email">Email Address <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Email Address" value="{{isset($data['user']->email) && !empty($data['user']->email) ? $data['user']->email : ''}}" autocomplete='off'>
                                </div>
                                <div class="form-group">
                                    <label for="first_name">First Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name" value="{{isset($data['user']->first_name) && !empty($data['user']->first_name) ? $data['user']->first_name : ''}}" autocomplete='off'>
                                </div>
                                <div class="form-group">
                                    <label for="last_name">Last Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="lastname" name="last_name" placeholder="Last Name" value="{{isset($data['user']->last_name) && !empty($data['user']->last_name) ? $data['user']->last_name : ''}}" autocomplete='off'>
                                </div>
                                <div class="form-group">
                                    <label for="mobile_no">Phone <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">IND +91</span>
                                        </div>
                                        <input type="text" class="form-control number" id="mobile_no" name="mobile_no" placeholder="Phone" maxlength="20" value="{{isset($data['user']->mobile_no) && !empty($data['user']->mobile_no) ? $data['user']->mobile_no : ''}}" autocomplete='off'>
                                    </div>
                                    
                                </div>
                                <div class="form-group">
                                    <label for="address1">Address Line 1</label>
                                    <input type="text" class="form-control" id="address1" name="address1" placeholder="Address Line 1" value="{{isset($data['user']->address1) && !empty($data['user']->address1) ? $data['user']->address1 : ''}}" autocomplete='off'>
                                </div>
                                <div class="form-group">
                                    <label for="address2">Address Line 2</label>
                                    <input type="text" class="form-control" id="address2" name="address2" placeholder="Address Line 2" value="{{isset($data['user']->address2) && !empty($data['user']->address2) ? $data['user']->address2 : ''}}" autocomplete='off'>
                                </div>
                                <div class="form-group">
                                    <label for="country">Country <span class="text-danger">*</span></label>
                                    <select class="form-control select2" id="country_id" name="country_id">
                                        <option value="">Select Country</option>
                                        @if(!empty($data['countryArr']))
                                        @foreach($data['countryArr'] as $countryArr)
                                        <option value="{{$countryArr->id}}" {{(isset($data['user']->country_id) && !empty($data['user']->country_id) && ($data['user']->country_id == $countryArr->id)) ? 'selected' : ''}}>{{$countryArr->country}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="pin_code">Pin Code <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control number" id="pin_code" name="pin_code" placeholder="Pin Code" maxlength="10" value="{{isset($data['user']->pin_code) && !empty($data['user']->pin_code) ? $data['user']->pin_code : ''}}" autocomplete='off'>
                                </div>
                                <div class="form-group">
                                    <label for="state">State <span class="text-danger">*</span></label>
                                    <select class="form-control select2" id="state_id" name="state_id">
                                        <option value="">Select State</option>
                                        @if(!empty($data['stateArr']))
                                        @foreach($data['stateArr'] as $stateArr)
                                        <option value="{{$stateArr->id}}" {{(isset($data['user']->state_id) && !empty($data['user']->state_id) && ($data['user']->state_id == $stateArr->id)) ? 'selected' : ''}}>{{$stateArr->state}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="city">City <span class="text-danger">*</span></label>
                                    <select class="form-control select2" id="city_id" name="city_id">
                                        <option value="">Select City</option>
                                        @if(!empty($data['cityArr']))
                                        @foreach($data['cityArr'] as $cityArr)
                                        <option value="{{$cityArr->id}}" {{(isset($data['user']->city_id) && !empty($data['user']->city_id) && ($data['user']->city_id == $cityArr->id)) ? 'selected' : ''}}>{{$cityArr->city}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="department">Department <span class="text-danger">*</span></label>
                                    <select class="form-control select2" id="department_id" name="department_id">
                                        <option value="">Select Department</option>
                                        @if(!empty($data['departmentArr']))
                                        @foreach($data['departmentArr'] as $departmentArr)
                                        <option value="{{$departmentArr->id}}" {{(isset($data['user']->department_id) && !empty($data['user']->department_id) && ($data['user']->department_id == $departmentArr->id)) ? 'selected' : ''}}>{{$departmentArr->name}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="role">Role <span class="text-danger">*</span></label>
                                    <select class="form-control select2" id="role_id" name="role_id">
                                        <option value="">Select Role</option>
                                        @if(!empty($data['userRoleArr']))
                                        @foreach($data['userRoleArr'] as $userRoleArr)
                                        <option value="{{$userRoleArr->id}}" {{(isset($data['user']->role_id) && !empty($data['user']->role_id) && ($data['user']->role_id == $userRoleArr->id)) ? 'selected' : ''}}>{{$userRoleArr->name}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="is_active">Is Active <span class="text-danger">*</span></label>
                                    <select class="form-control select2" id="is_active" name="is_active" {{$result['disabled']}}>
                                        <option value="0" {{(isset($data['user']->is_active) && !empty($data['user']->is_active) && ($data['user']->is_active == 0)) ? 'selected' : ''}}>No</option>
                                        <option value="1" {{(isset($data['user']->is_active) && !empty($data['user']->is_active) && ($data['user']->is_active == 1)) ? 'selected' : ''}}>Yes</option>
                                    </select>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="icon-button" title="Save"><i class="fas fa-3x fa-save tooltips text-success" aria-hidden="true"></i></button>
                                <button type="button" class="icon-button" title="Cancel"><a href="{{url('users')}}"><i class="fas fa-3x fa-times-circle tooltips text-danger" aria-hidden="true"></i></a></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>  
@endsection

@push('script')
    <script src="{{js('add_user_js')}}"></script>
@endpush