
@extends('layout.layout')

@section('title')
    find id fin
@endsection

@section('login.script')
    @if($errors->any())
        const confirmModal = document.getElementById("confirm-modal");
        confirmModal.classList.remove("dn");
        const confirmModalOk = document.getElementById("confirm-modal-ok");
        confirmModalOk.addEventListener("click", () => {
        confirmModal.classList.add("dn");
        })
    @endif
@endsection

@section('modal.content')
    @if($errors->any())
        {!! nl2br($errors->first()) !!}
    @endif
@endsection

@section('content')
    <div class="bg-white">
        <!-- compact header -->
{{--        <header class="comp-header">--}}
{{--            <h1 class="comp-header__logo">로고</h1>--}}
{{--        </header>--}}
        <!-- //compact header -->

        <!-- find id fin -->
        <div class="content__wrap white">
            <div class="content">
                <h2 class="content__tit">아이디 찾기</h2>
                <div class="login-before__box">
                    <p class="login-before__guide mb-10">회원님은 <span>{{ $email }}</span> 로 가입하셨습니다.</p>
                    <p class="login-before__guide2">개인 정보 보호를 위해 이메일 일부는 숨김 처리됩니다.</p>
                </div>
                <div class="a-center">
                    <a href="{{ route('user.findPwView') }}" class="btn btn-normal col2 btn-round btn-primary btn-line mb-10">비밀번호 찾기</a>
                    <br>
                    <a href="{{ route('user.loginView') }}" class="btn btn-normal col2 btn-round btn-primary">로그인</a>
                </div>
            </div>
        </div>
        <!-- //find id fin -->
    </div>
@endsection





