@extends('backup.design.layouts.app')
@section('content')
<div class="roc-register-header">
    <img src="{{url('/img/logo.png')}}" class="logo-ico" alt="logo" />
</div>
@yield('auth_content')
@include('backup.common.footer')
@endsection
@section('script')
@yield('auth_script')
@endsection
