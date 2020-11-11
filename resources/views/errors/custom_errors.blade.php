@extends('layouts.layout')

@section('content')
<div class="container">
    <div class="center" style="margin-top: 90px; margin-bottom: 30px; text-align: center">
    <h2>{{ $exception->getMessage() }}</h2>
    </div>
</div>

@endsection