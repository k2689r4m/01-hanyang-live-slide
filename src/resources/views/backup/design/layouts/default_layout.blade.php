<!-- 헤더 푸터를 포함하는 기본 레이아웃 입니다. -->
@extends('backup.design.layouts.app')
@section('content')
@include('backup.common.header')
@yield('default_content')
@include('backup.common.footer')
@endsection
@section('script')
@yield('default_script')
@endsection
