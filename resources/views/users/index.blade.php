@extends('layouts.layout')

@section('content')
<?php
$privilegeArr = isset($result['privileges']['display_name']) ? $result['privileges']['display_name'] : array();
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">

    </div>
    <!-- /.content-header -->
    @if($status!='failed')
    <!-- Main content -->
    <section class="content">
        <div class="container">
            <div class="container-fluid">
                <div class="row">

                    <div class="card">
                        <div class="card-header border-0">
                            <div class="header-details">
                                <div class="name-area">
                                    <h2 class="m-0 text-dark">Users</h2>
                                </div>
                                <div class="action-area">


                                    <form action="{{url('csv-export')}}" method="post">
                                        @csrf
                                        <input type="hidden" name="key" value="Users">
                                        <button type="submit" class="btn btn-primary float-right tooltips "><i class="fa fa-file-excel"></i> Export</button>
                                    </form>


                                    <a href="{{url('user')}}" class="btn btn-success tooltips" data-placement="top">
                                        <i class="fa fa-plus"></i> Add New User
                                    </a>

                                </div>
                            </div>
                        </div>

                        <!-- /.card-header -->
                        <div class="col-md-12 table p-4">
                           <table id="userlisttbl" class="table table-striped table-responsive">

                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th width="15%"> User Name</th>
                                        <th>Phone</th>
                                        <th>Address</th>
                                        <th>Email</th>
                                        <th>Department</th>
                                        <th>Role</th>
                                        <th>Is Active</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($result['result'] as $result)
                                    <tr>
                                        <td>{{$result->id}}</td>
                                        <td>{{$result->first_name}} {{$result->last_name}}</td>
                                        <td>{{$result->mobile_no}}</td>
                                        <td>{{!empty($result->address1) ? $result->address1 : ''}}<br />{{!empty($result->address2) ? $result->address2 : ''}}</td>
                                        <td>{{$result->email}}</td>
                                        <td>{{$result->department->name}}</td>
                                        <td>{{$result->userRole->name}}</td>
                                        <td>{{($result->is_active) ? 'Active' : 'Inactive'}}</td>


                                        <td align="center">
                                            <a class="btn" title="Update User" href="{{url('user/'.$result->id)}}"><i class="fas fa-user-edit"></i></a>
                                        </td>

                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </div>
    </section>
    <!-- /.content -->
    @endif
</div>
@endsection

@push('script')
<script src="{{js('user_list_js')}}"></script>
@endpush