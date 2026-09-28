@extends('layout.layout')


@section('title')
    find id
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


@section('content')
<div class="bg-white">
    <div class="dim dn" id="confirm-modal">
        <div class="alert pf">
            <div class="alert__con">
                @if(Session::has('RESENT_VERIFICATION_EMAIL'))
                    {!! nl2br(Session::get('RESENT_VERIFICATION_EMAIL')) !!}
                @elseif($errors->any())
                    {{--        {{ $errors->first() }}--}}
                    {!! nl2br($errors->first()) !!}
                @endif
            </div>
            <div class="alert__bottom">
                <div class="alert__btn-wrap">
                    <button class="alert__btn primary" id="confirm-modal-ok">확인</button>
                </div>
            </div>
        </div>
    </div>

    <!-- find id -->
    <div class="content__wrap white">
        <div class="content">
            <h2 class="content__tit">아이디 찾기</h2>
            <div class="login-before__box">
                <p class="login-before__guide2 top">가입 시 입력한 정보를 통해 아이디(이메일)를 찾을 수 있습니다.</p>
            </div>
            <div class="input-box">
                <form action="{{ route('user.findId') }}" method="post">
                    @csrf
                    <div class="input-box__input mb-20">
                        <label class="input-box__label" name="name" value="{{ old('name') }}" >이름 </label>
                        <input type="text" placeholder="이름을 입력해주세요." name="name" />
                    </div>
                    <div class="input-box__input">
                        <label class="input-box__label">휴대폰 번호 </label>
                        <input type="text" placeholder="01012345678" name="contact" value="{{ old('contact') }}"/>
                    </div>
                    <div class="a-center">
{{--                        <a href="find_id_fin.html" class="btn btn-normal col2 btn-round btn-primary">아이디 찾기</a>--}}
                        <button type="submit" class="btn btn-normal col2 btn-round btn-primary">아이디 찾기</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- //find id -->
</div>
@endsection


{{--메일 : thdrudwls7@gmail.com--}}
{{--이름 :--}}
{{--번호 : 01012341234--}}



{{--<form action="{{ route('user.findId') }}" method="post">--}}
{{--    @csrf--}}
{{--    <input type="text" name="name" placeholder="name" value="{{ old('name') }}" /><br/>--}}
{{--    <input type="text" name="contact" placeholder="contact" value="{{ old('contact') }}" /><br/>--}}
{{--    <button type="submit">Find ID</button>--}}
{{--    {{ $errors }}--}}
{{--</form>--}}
