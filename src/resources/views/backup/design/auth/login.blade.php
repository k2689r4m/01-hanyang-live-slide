@extends('backup.design.layouts.app')

@section('content')
<div class="roc-login-container">
    <div class="roc-login-content">
        <img src="{{url('/img/logo.png')}}" class="logo-ico" alt="logo" />
        <div class="roc-login-form">
            <input type="text" class="roc-input-box input-id" placeholder="아이디를 입력하세요." />
            <input type="password" class="roc-input-box input-pw" placeholder="비밀번호를 입력하세요." />
            <a href="#" class="find-id-pw">아이디 찾기 / 비밀번호 찾기</a>
            <button type="button" class="roc-btn-green roc-login-btn">로그인</button>
            <button type="button" class="roc-btn-green inverse roc-signup-btn">회원가입</button>
        </div>
    </div>
</div>
@include('backup.common.footer')
@endsection
@section('script')
    $(document).ready(() => {
        Login.init();
    });
@endsection
