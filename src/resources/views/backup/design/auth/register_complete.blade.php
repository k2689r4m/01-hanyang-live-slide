@extends('backup.design.layouts.auth_layout')
@section('auth_content')
<div class="roc-register-complete-container">
    <div class="roc-content">
        <h2>본인 인증</h2>
        <img src="/img/register-complete.svg" alt="register complete" class="complete-icon" />
        <h3>가입을 축하합니다!</h3>
        <p>입력하신 이메일 <span class="strong">ID@email.com</span>로 회원가입 인증메일이 발송되었습니다.<br />메일에 있는 본인 인증 URL를 클릭하여 인증을 완료해주세요!</p>
        <span>미인증 시 서비스 사용이 어렵습니다.<br/>인증URL을 보내는 데 약간의 시간이 소요될 수 있습니다.</span>
        <button type="button" class="roc-btn-green roc-ellipse-btn">메인으로</button>
    </div>
</div>
@endsection
@section('auth_script')
$(document).ready(() => {
    RegisterComplete.init();
});
@endsection
