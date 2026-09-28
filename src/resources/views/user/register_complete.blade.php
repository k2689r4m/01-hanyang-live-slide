@extends('layout.layout')

@section("title")
    회원가입 완료
@endsection

@section('content')

<div class="bg-white">
    <!-- compact header -->
    <header class="comp-header">
        <h1 class="comp-header__logo">로고</h1>
    </header>
    <!-- //compact header -->

        <!-- join stay -->
    <div class="content__wrap white">
        <div class="content">
            <h2 class="content__tit">본인인증</h2>
            <div class="login-before__box">
                <img src="../images/icon/check_lg_primary.png" alt="check_icon" />
                <p class="login-before__noti">가입을 축하합니다!</p>
                <p class="login-before__guide">입력하신 이메일 <strong>{{ $user['email'] }}</strong>로 회원가입 인증메일이 발송되었습니다.<br>메일에 있는 본인 인증 URL을 클릭하여 인증을 완료해주세요!</p>
                <p class="login-before__guide2">미인증 시 서비스 사용이 어렵습니다.<br>인증URL을 보내는 데 약간의 시간이 소요될 수 있습니다.</p>
                <a href={{ route('user.loginView') }} class="btn btn-normal col2 btn-round btn-primary">메인으로</a>
            </div>
        </div>
    </div>
    <!-- //join stay -->
    </div>
</div>

@endsection