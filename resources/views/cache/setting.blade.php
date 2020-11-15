
@extends('layouts.layout')
@section('content')
<?php 
     $privilegeArr = isset( $result['privileges']['display_name'])? $result['privileges']['display_name']:array();
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Settings</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Settings</a></li>
                        <li class="breadcrumb-item active">Cache</li>
                    </ol>
                </div>
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <div class="container">
            @if(in_array('CACHEMENU',$privilegeArr))
                <button class="btn" id="delCacheRole"> Cache Menu</button>
            @endif
            @if(in_array('CACHEDATA',$privilegeArr))
                <button class="btn" id="delCacheData"> Cache Data </button>
            @endif
            <!-- /.container-fluid -->
        </div>
    </section>
    <!-- /.content -->
</div>
@endsection
@push('script')
<script src="{{ js('setting_js') }}"></script>
@endpush