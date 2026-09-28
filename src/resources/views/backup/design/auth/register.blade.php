@extends('backup.design.layouts.auth_layout')
@section('auth_content')
<div class="roc-register-container">
    <div class='roc-register-form'>
        <h2>회원가입</h2>
        <div class="agreement-section">
            <div class="roc-form-section">정보수집, 약관 동의</div>
            <div>
                <label class="roc-checkbox" for="checkbox_1">
                    <input type="checkbox" id="checkbox_1" />
                    <span></span>
                </label>
                <label class='roc-form-required roc-form-label'>이용약관 동의</label>
            </div>
            <textarea class="roc-textarea mb" readonly></textarea>
            <div>
                <label class="roc-checkbox" for="checkbox_2">
                    <input type="checkbox" id="checkbox_2" />
                    <span></span>
                </label>
                <label class='roc-form-required roc-form-label'>정보수집 동의</label>
            </div>
            <textarea class="roc-textarea" readonly></textarea>
        </div>
        <div class="roc-form-section">회원정보</div>
        <div class="form-section">
            <div class="form-group">
                <label class='roc-form-required roc-form-label' for="email">이메일</label>
                <input type="text" id="email" class="roc-input-box roc-form-input-box" placeholder="user01@gmail.com" />
            </div>
            <div class="form-group">
                <label class='roc-form-required roc-form-label' for="phone">휴대폰 번호</label>
                <input type="text" id="phone" class="roc-input-box roc-form-input-box" placeholder="01012345678" />
            </div>
            <div class="form-group">
                <label class='roc-form-required roc-form-label' for="pw">비밀번호</label>
                <input type="password" id="pw" class="roc-input-box roc-form-input-box" placeholder="비밀번호를 입력해주세요." />
            </div>
            <div class="form-group">
                <label class='roc-form-required roc-form-label' for="pw_confirm">비밀번호 확인</label>
                <input type="password" id="pw_confirm" class="roc-input-box roc-form-input-box" placeholder="비밀번호를 다시 한번 입력해주세요." />
            </div>
            <div class="form-group">
                <label class='roc-form-required roc-form-label' for="name">이름</label>
                <input type="text" id="name" class="roc-input-box roc-form-input-box error" placeholder="홍길동" />
                <div class="error-msg">
                    <span class="roc-error-message">이름을 입력하세요.</span>
                </div>
            </div>
            <div class="form-group">
                <label class='roc-form-required roc-form-label' for="nickname">닉네임</label>
                <input type="text" id="nickname" class="roc-input-box roc-form-input-box" placeholder="길동" />
            </div>
            <div class="form-group">
                <label class='roc-form-required roc-form-label' for="gender">성별</label>
                <div class="gender-radios">
                    <div>
                        <label class="roc-radio" for="male">
                            <input type="radio" name="option" id="male" />
                            <span></span>
                        </label>
                        <span>남</span>
                    </div>
                    <div>
                        <label class="roc-radio" for="female">
                            <input type="radio" name="option" id="female" />
                            <span></span>
                        </label>
                        <span>여</span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class='roc-form-required roc-form-label' for="nickname">생년월일</label>
                <input type="text" id="nickname" class="roc-input-box roc-form-input-box" placeholder="19910101" />
            </div>
            <div class="form-group submit-form">
                <button type="button" id="submit" class="roc-btn-green roc-ellipse-btn">회원가입</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('auth_script')
    $(document).ready(() => {
        Register.init();
    })
@endsection
