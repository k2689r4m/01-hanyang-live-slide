@extends('backup.design.layouts.auth_layout')
@section('auth_content')
<div class="roc-find-id-container">
    <div class="roc-content">
        <h2>아이디 찾기</h2>
        <span>가입 시 입력한 정보를 통해 아이디(이메일)를 찾을 수 있습니다.</span>
        <form>
            <div class='roc-form-group'>
                <label for="name">이름</label>
                <input type="text" id="name" class="roc-input-box roc-form-input-box" placeholder="이름을 입력해주세요." />
            </div>
            <div class='roc-form-group'>
                <label for="name">휴대폰 번호</label>
                <input type="text" id="name" class="roc-input-box roc-form-input-box" placeholder="01012345678" />
            </div>
            <button type="button" id="submit" class="roc-btn-green roc-ellipse-btn">아이디 찾기</button>
        </form>
    </div>
</div>
@endsection
@section('auth_script')
$(document).ready(() => {
    FindId.init();
});
@endsection
