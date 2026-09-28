@extends('backup.design.layouts.default_layout')
@section('default_content')
<div class="roc-support">
    <form>
        <h2>문의</h2>
        <span>문의사항이 있으신가요? 저희에게 알려주세요.</span>
        <div class="form-section">
            <div class="form-group">
                <label class='roc-form-required roc-form-label' for="email">이메일</label>
                <input type="text" id="email" class="roc-input-box roc-form-input-box" placeholder="답변받을 이메일을 입력해주세요. " />
            </div>
            <div class="form-group">
                <label class='roc-form-required roc-form-label' for="name">이름</label>
                <input type="text" id="name" class="roc-input-box roc-form-input-box" placeholder="이름을 입력해주세요. " />
            </div>
            <div class="form-group">
                <label class='roc-form-required roc-form-label' for="title">문의 제목</label>
                <input type="text" id="title" class="roc-input-box roc-form-input-box" placeholder="문의 제목을 입력해주세요. " />
            </div>
            <div class="form-group content">
                <label class='roc-form-required roc-form-label' for="content">문의 내용</label>
                <textarea id="content" class="roc-textarea" placeholder="문의 내용을 입력해주세요."></textarea>
            </div>
            <div class="agreement">
                <label class="roc-checkbox" for="checkbox_1">
                    <input type="checkbox" id="checkbox_1" />
                    <span></span>
                </label>
                <label class='roc-form-required roc-form-label'>(필수) 개인정보 수집에 동의합니다.</label>
            </div>
            <div class="form-group submit-form">
                <button type="button" id="submit" class="roc-btn-green roc-ellipse-btn">등록</button>
            </div>
        </div>
    </form>
</div>
@endsection
@section('default_script')
$(document).ready(() => {
    Support.init();
});
@endsection
