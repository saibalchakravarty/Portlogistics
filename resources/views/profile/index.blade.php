@extends('layouts.layout')

@section('content')
<?php
$imgpath = images('default_profile_photo');
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0 text-dark">My Profile</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <div class="container">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="alert alert-success hide" id="profile-success">
                                <button type="button" class="close close-alert">&times;</button>
                                <span class="message"></span>
                            </div>
                            <div class="alert alert-danger hide" id="profile-error">
                                <button type="button" class="close close-alert">&times;</button>
                                <span class="message"></span>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="col-sm-4 float-left">
                                    <div class="mb20">
                                        <img src="{{(Auth::user()->image_path)? asset('storage/'.Auth::user()->image_path) : $imgpath }}" alt="Profile Photo" class="profile-pic"/>
                                    </div>
                                    <div>

                                        <button style="min-width: 11rem;" class="btn btn-primary tooltips " id="btnImgUpload" data-toggle= "modal" data-target="#modal-profile-upload">Update Photo</button>
                                       
                                    </div>
                                    <button style="min-width: 11rem; margin-top:0.5rem" class="btn btn-primary tooltips  " id="changePasswordBtn">Change Password</button>  

                                </div>
                                <div class="col-sm-4 float-left">
                                    <div style="height:130px;">
                                        <form id="changeNameForm" method="post">
                                            <div class="profile-div">
                                                <span><label for="name">Name &nbsp;</label></span>
                                                <span class="profile-name-edit default-view"><i class="fa fa-pen"></i></span>
                                                <span class="profile-name-save edit-view">
                                                    <button class="btn" type="submit"><i class="fa fa-save"></i></button>
                                                </span>
                                            </div>
                                            <div class="profile-div mb20 default-view" id="profile_name">
                                                {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
                                            </div>
                                            <div class="profile-div mb20 edit-view" id="updateNameDiv">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <input type="text" class="form-control" placeholder="First Name" value="{{ Auth::user()->first_name }}" name="first_name" id="first_name" default="{{ Auth::user()->first_name }}">
                                                    </div>
                                                    <div class="col-6">
                                                        <input type="text" class="form-control" placeholder="Last Name" value="{{ Auth::user()->last_name }}" name="last_name" id="last_name" default="{{ Auth::user()->last_name }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </form>   
                                    </div>
                                    <div class="profile-div">
                                        
                                    </div>
                                </div>
                                <div class="col-sm-4 clear-both">
                                    <div class="modal fade" id="changePasswordModal">
                                        <form id="changePasswordForm" method="post">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Change Password</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb20">
                                                            <input class="form-control" type="password" name="old_password" id="old_password" placeholder="Current Password"/>
                                                        </div>
                                                        <div class="mb20">
                                                            <input class="form-control" type="password" name="new_password" id="new_password" placeholder="New Password"/>
                                                        </div>
                                                        <div>
                                                            <input class="form-control" type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password"/>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                       
                                                        <button type="button" class="icon-button" data-dismiss="modal" title="Cancel"><i class="fas fa-2x fa-times-circle tooltips text-danger"></i></button>
              <button type="submit" class="icon-button" title="Save"><i class="fas fa-2x fa-save tooltips text-success"></i></button>


                                                    </div>
                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                        <form id="frmProfileUpload" enctype="multipart/form-data">
                            <div class="modal fade" id="modal-profile-upload">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="mdlProfileImgTitle">Upload Photo</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                        <div class="modal-body">
                                            <div class="row">
                                                <ul class="text-danger">
                                                    <li><b>Image Type :PNG,JPG and JPEG</b> </li>
                                                    <li><b>Image Size :Maximum 2MB </b></li>
                                                </ul>
                                            </div>
                                           <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="profileImage" name="image" onchange="validateFileUpload();">
                                                <label class="custom-file-label" for="profileImage" id="lblProfileImage">Choose file</label>
                                            </div>
                                        </div>
                                        <div class="modal-footer justify-content">
                                            <div class="form-group">
                                                <button type="button" class="icon-button" data-dismiss="modal" title="Cancel"><i class="fas fa-2x fa-times-circle tooltips text-danger"></i></button>
                                                <button type="button" class="icon-button" data-placement="top" title="Save" id="btnProfileImgUpldSubmit"><i class="fas fa-2x fa-save tooltips text-success"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                        </form>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
    </section>
    <!-- /.content -->
</div>
@endsection

@push('script')
<script src="{{js('profile_js')}}"></script>
@endpush