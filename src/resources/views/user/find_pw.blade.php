@extends('layout.layout')

@section("title")
    Find PW
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

    @if(!!($complete ?? ''))
        const confirmModal = document.getElementById("confirm-modal");
        confirmModal.classList.remove("dn");
        const confirmModalOk = document.getElementById("confirm-modal-ok");
        confirmModalOk.addEventListener("click", () => {

        confirmModal.classList.add("dn");
        location.href = `{{ route('user.login') }}`
        })
    @endif
@endsection

@section('content')
    <div class="bg-white">
        <div class="dim dn" id="confirm-modal">
            <div class="alert pf">
                <div class="alert__con">
                    @if($errors->any())
                        {!! nl2br($errors->first()) !!}
                    @elseif($complete ?? '')
                        {!! nl2br("입력하신 메일로 임시\n비밀번호가 전송되었습니다.") !!}
                    @endif
                </div>
                <div class="alert__bottom">
                    <div class="alert__btn-wrap">
                        <button class="alert__btn primary" id="confirm-modal-ok">확인</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="content__wrap white">
            <div class="content">
                <h2 class="content__tit">비밀번호 찾기</h2>
                <div class="login-before__box">
                    <p class="login-before__guide2 top">가입 시 입력한 정보로 임시비밀번호를 보내드립니다.</p>
                </div>
                <div class="input-box">
                    <form action="{{ route('user.findPw') }}" method="post">
                        @csrf
                        <div class="input-box__input mb-20">
                            <label class="input-box__label">아이디(이메일) </label>
                            <input type="text" placeholder="user01@gmai.com" name="email" value="{{ old('email') }}"/>
                        </div>
                        <div class="input-box__input mb-20">
                            <label class="input-box__label">이름 </label>
                            <input type="text" placeholder="이름을 입력해주세요." name="name" alue="{{ old('name') }}"/>
                        </div>
                        <div class="input-box__input">
                            <label class="input-box__label">휴대폰 번호 </label>
                            <input type="text" placeholder="01012345678" name="contact" value="{{ old('contact') }}"/>
                        </div>
                        <div class="a-center">
                            <button type="submit" class="btn-normal col2 btn-round btn-primary">임시 비밀번호 전송</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- //find id -->
    </div>
@endsection










{{--<form action="{{ route('user.findPw') }}" method="post">--}}
{{--    @csrf--}}
{{--    <div class="bg-white">--}}
{{--        <!-- compact header -->--}}
{{--        <header class="comp-header">--}}
{{--            <h1 class="comp-header__logo">로고</h1>--}}
{{--        </header>--}}
{{--        <!-- //compact header -->--}}

{{--        <!-- find id -->--}}
{{--        <div class="content__wrap white">--}}
{{--            <div class="content">--}}
{{--                <h2 class="content__tit">비밀번호 찾기</h2>--}}
{{--                <div class="login-before__box">--}}
{{--                    <p class="login-before__guide2 top">가입 시 입력한 정보로 임시비밀번호를 보내드립니다.</p>--}}
{{--                </div>--}}
{{--                <div class="input-box">--}}
{{--                    <form action="{{ route('user.findPw') }}" method="post">--}}
{{--                        <div class="input-box__input mb-20">--}}
{{--                            <label class="input-box__label">아이디(이메일) </label>--}}
{{--                            <input type="text" placeholder="user01@gmai.com" name="email" value="{{ old('email') }}"/>--}}
{{--                        </div>--}}
{{--                        <div class="input-box__input mb-20">--}}
{{--                            <label class="input-box__label">이름 </label>--}}
{{--                            <input type="text" placeholder="이름을 입력해주세요." name="name" alue="{{ old('name') }}"/>--}}
{{--                        </div>--}}
{{--                        <div class="input-box__input">--}}
{{--                            <label class="input-box__label">휴대폰 번호 </label>--}}
{{--                            <input type="text" placeholder="01012345678" name="contact" value="{{ old('contact') }}"/>--}}
{{--                        </div>--}}
{{--                        <div class="a-center">--}}
{{--                            <button type="button" class="btn-normal col2 btn-round btn-primary">임시 비밀번호 전송</button>--}}
{{--                        </div>--}}
{{--                        모달, 임시 비밀번호 전송 기능 미구현--}}
{{--                    </form>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</form>--}}
{{--{{$errors}}--}}

{{--    Find PW<br/>--}}
{{--    <input type="text" name="email" placeholder="email" value="{{ old('email') }}" /><br/>--}}
{{--    <input type="text" name="name" placeholder="name" value="{{ old('name') }}" /><br/>--}}
{{--    <input type="text" name="contact" placeholder="contact" value="{{ old('contact') }}" /><br/>--}}
{{--    <button type="submit">Find PW</button>--}}
{{--    {{ $errors }}--}}
{{--    @isset ($complete)--}}
{{--        Sent an email--}}
{{--    @endisset--}}
{{--</form>--}}
