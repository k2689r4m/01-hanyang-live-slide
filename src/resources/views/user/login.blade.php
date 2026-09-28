@extends('layout.login_layout')


@section('title')
    login
@endsection


@section('login.script')
    const emailVerifyConfirmModal = document.getElementById('email-verify-confirm-modal');
    const confirmModal = document.getElementById("confirm-modal");

    function showEmailVerifyConfirmModal() { emailVerifyConfirmModal.classList.remove('dn'); }
    function showConfirmModal() { confirmModal.classList.remove('dn'); }

    emailVerifyConfirmModal.querySelector('.cancel-btn').addEventListener('click', () => {
    emailVerifyConfirmModal.classList.add('dn');
    });

    confirmModal.querySelector("#confirm-modal-ok").addEventListener("click", () => {
    confirmModal.classList.add("dn");
    });

    @if(Session::has('RESENT_VERIFICATION_EMAIL'))
        showConfirmModal();
    @elseif($errors->has('INVALID_VERIFICATION_EMAIL'))
        // 악용 방지 위해 인증 실패시만 리센드 주소 노출.
        emailVerifyConfirmModal.querySelector('.resend-btn').addEventListener('click', () => {
        location.href = '{{ route('user.emailReverify', ['email' => $errors->first('INVALID_VERIFICATION_EMAIL')]) }}';
        emailVerifyConfirmModal.classList.add('dn');
        });

        showEmailVerifyConfirmModal();
    @elseif($errors->any())
        showConfirmModal();
    @endif
@endsection
@section('content')
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
    <div class="dim dn" id="email-verify-confirm-modal">
        <div class="alert alert-md">
            <div class="alert__con">
                이메일 인증이 안된 회원입니다.<br>
                메일에서 받은 인증 URL을 확인해주세요.<br>
                만약 URL을 받지 못한 경우<br>
                인증URL 재전송을 눌러 새 인증URL로 접속해주세요.
            </div>
            <div class="alert__bottom">
                <div class="alert__btn-wrap">
                    <button class="alert__btn gray cancel-btn">기존 메일을 확인할게요</button>
                </div>
                <div class="alert__btn-wrap">
                    <button class="alert__btn primary resend-btn">새 인증 URL 받기</button>
                </div>
            </div>
        </div>
    </div>
    <div class="bg-white">
        <!-- login -->
        <div class="login__wrap">
            <div class="login">
                <h1 class="login__logo">로고</h1>
                <form method="post" action="{{ route('user.login') }}">
                    @csrf
                    <input class="input-lg" type="text" placeholder="아이디를 입력하세요." name="email" value="{{ old('email') }}"/>
                    <input class="input-lg" type="password" placeholder="비밀번호를 입력하세요." name="password"  />

                    <button type="submit" class="btn-lg btn-primary">로그인</button>
                    <div class="login__find">
                        <a href="{{route('user.findIdView')}}">아이디 찾기</a> / <a href="{{ route('user.findPwView') }}">비밀번호 찾기</a>
                    </div>
                    <ul class="sns-login">
                        <li class="sns-login__item" onclick="location.href=`{{ route('auth.naver.login') }}`">
                            <img src="../images/icon/sns_naver.png" alt="" />
                            <span>네이버 로그인</span>
                        </li>
                        <li class="sns-login__item" onclick="location.href=`{{ route('auth.kakao.login') }}`">
                            <img src="../images/icon/sns_kakao.png" alt="" />
                            <span>카카오 로그인</span>
                        </li>
                        <li class="sns-login__item" onclick="location.href=`{{ route('auth.google.login') }}`">
                            <img src="../images/icon/sns_google.png" alt="" />
                            <span>구글 로그인</span>
                        </li>
                        <li class="sns-login__item" onclick="location.href=`{{ route('auth.facebook.login') }}`">
                            <img src="../images/icon/sns_facebook.png" alt="" />
                            <span>페이스북 로그인</span>
                        </li>
                    </ul>

                    <a href="{{ route('user.plushRegisterView') }}"  class="btn btn-lg btn-primary btn-line">회원가입</a>
                </form>
            </div>
        </div>

    {{--        <a href="{{ route('user.findIdView') }}">find id</a><br/>--}}
    {{--        <a href="{{ route('user.findPwView') }}">find pw</a><br/>--}}
    {{--        <hr />--}}
    {{--        <a href="{{ route('user.plushRegisterView') }}">register</a><br/>--}}
    {{--        <a href="{{ route('auth.kakao.login') }}">kakao login</a><br/>--}}
    {{--        <a href="{{ route('auth.naver.login') }}">naver login</a><br/>--}}
    {{--        <a href="{{ route('auth.google.login') }}">google login</a><br/>--}}
    {{--        <a href="{{ route('auth.facebook.login') }}">facebook login</a>--}}
    <!-- //login -->

        {{--        <div class="alert g-unfix">--}}
        {{--            <div class="alert__con">--}}
        {{--                @yield('modal.content')--}}
        {{--            </div>--}}
        {{--            <div class="alert__bottom">--}}
        {{--                <div class="alert__btn-wrap">--}}
        {{--                    <button class="alert__btn primary">확인</button>--}}
        {{--                </div>--}}
        {{--            </div>--}}
        {{--        </div>--}}
    </div>

    {{--백업--}}

    {{--    <form method="post" action="{{ route('user.login') }}">--}}
    {{--        @csrf--}}
    {{--        Login<br/>--}}
    {{--        <input type="text" name="email" placeholder="email" value="{{ old('email') }}"/>--}}
    {{--        <input type="text" name="password" placeholder="password"/>--}}
    {{--        <button type="submit">Login</button>--}}
    {{--        {{ $errors }}--}}
    {{--    </form>--}}
    {{--    <a href="{{ route('user.findIdView') }}">find id</a><br/>--}}
    {{--    <a href="{{ route('user.findPwView') }}">find pw</a><br/>--}}
    {{--    <hr />--}}
    {{--    <a href="{{ route('user.plushRegisterView') }}">register</a><br/>--}}


@endsection


