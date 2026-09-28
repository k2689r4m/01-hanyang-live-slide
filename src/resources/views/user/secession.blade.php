@extends('layout.layout')

@section('title')
    회원탈퇴
@endsection

@section('content')
    <div class="dim dn" id="secessionAlert">
        <div class="alert">
            <div class="alert__con"></div>
            <div class="alert__bottom">
                <div class="alert__btn-wrap">
                    <button class="alert__btn primary ok-btn">확인</button>
                </div>
            </div>
        </div>
    </div>
    <div class="dim dn" id="secessionConfirm">
        <div class="alert">
            <div class="alert__con"></div>
            <div class="alert__bottom">
                <div class="alert__btn-wrap">
                    <button class="alert__btn gray" id="cancel" onclick="event.target.parentNode.parentNode.parentNode.parentNode.classList.add('dn')">취소</button>
                </div>
                <div class="alert__btn-wrap">
                    <button class="alert__btn primary ok-btn">확인</button>
                </div>
            </div>
        </div>
    </div>
    <div class="page-nav-wrap">
        <ul class="page-nav gray">
            <li class="page-nav__item home"></li>
            <li class="page-nav__item">내정보</li>
            <li class="page-nav__item">개인정보</li>
            <li class="page-nav__item">회원탈퇴</li>
        </ul>
    </div>
    <div class="content__wrap exist-nav exist-leftmenu round">
        <div class="content">
            <form method="post" action="{{ route('user.secession') }}" id="frmSecession">
                @csrf
            <h2 class="content__tit">탈퇴 시 주의 사항</h2>
            <!-- 탈퇴 -->
            <div class="txt-box lg">
                예시글 입니다. 예시글 입니다. 예시글 입니다. 예시글 입니다. 예시글 입니다. 예시글 입니다. 예시글 입니다. 예시글 입니다. 예시글 입니다. 예시글 입니다. 예시글 입니다. 예시글 입니다. 예시글 입니다. 예시글 입니다. 예시글 입니다. 예시글 입니다. 예시글 입니다. 예시글 입니다. 예시글 입니다.
                예시글 입니다. 예시글 입니다. 예시글 입니다. 예시글 입니다. 예시글 입니다. 예시글 입니다. 예시글 입니다. 예시글 입니다. 예시글 입니다. 예시글 입니다. 예시글 입니다. 예시글 입니다. 예시글 입니다. 예시글 입니다. 예시글 입니다. 예시글 입니다. 예시글 입니다. 예시글 입니다. 예시글 입니다. 예시글 입니다. 예시글 입니다.
                예시글 입니다. 예시글 입니다. 예시글 입니다. 예시글 입니다. 예시글 입니다. 예시글 입니다. 예시글 입니다. 예시글 입니다. 예시글 입니다. 예시글 입니다. 예시글 입니다. 예시글 입니다. 예시글 입니다. 예시글 입니다. 예시글 입니다. 예시글 입니다. 예시글 입니다. 예시글 입니다. 예시글 입니다. 예시글 입니다. 예시글 입니다. 예시글 입니다. 예시글 입니다. 예시글 입니다. 예시글 입니다. 예시글 입니다. 예시글 입니다. 예시글 입니다.
                예시글 입니다. 예시글 입니다. 예시글 입니다. 예시글 입니다. 예시글 입니다. 예시글 입니다. 예시글 입니다. 예시글 입니다. 예시글 입니다. 예시글 입니다. 예시글 입니다. 예시글 입니다. 예시글 입니다. 예시글 입니다. 예시글 입니다. 예시글 입니다. 예시글 입니다. 예시글 입니다. 예시글 입니다. 예시글 입니다. <br><br><br>
            </div>
            <div class="a-center">
                <label class="checkbox">
                    <input type="checkbox" name="required_check_box" />해당 안내문을 모두 확인하였으며, 탈퇴시 회원 정보가 모두 삭제되고 복구가 불가함에 동의합니다.
                </label>
            </div>
            <div class="a-center p-50">
                <button type="button" class="btn-gray btn-line btn-normal col2 btn-round" onclick="history.back()">취소</button>
                <button class="btn-primary btn-normal col2 btn-round">탈퇴</button>
            </div>
            <br><br><br>
            <!-- //탈퇴 -->
            </form>
        </div>
    </div>
@endsection
@section('user.myinfo.script')
    const frmSecession = document.querySelector('#frmSecession');

    function showAlert(content, okCallback) {
    const alert = document.getElementById('secessionAlert');
    alert.classList.remove('dn');
    alert.querySelector('.alert__con').innerHTML = content;

    // 기존에 등록된 모달 이벤트를 제거합니다.
    const handleOk = () => {
        if (okCallback) okCallback();
            alert.classList.add('dn');
        };
        alert.querySelector('.ok-btn').removeEventListener('click', this.okCallback);
        this.okCallback = handleOk;
        alert.querySelector('.ok-btn').addEventListener('click', handleOk);
    }

    function showConfirm(content, okCallback) {
        const confirm = document.getElementById('secessionConfirm');
        confirm.classList.remove('dn');
        confirm.querySelector('.alert__con').innerHTML = content;
        // 기존에 등록된 모달 이벤트를 제거합니다.
        const handleOk = () => {
            if (okCallback) okCallback();
            confirm.classList.add('dn');
        };
        confirm.querySelector('.ok-btn').removeEventListener('click', this.okCallback);
        this.okCallback = handleOk;
        confirm.querySelector('.ok-btn').addEventListener('click', handleOk);
    }

    frmSecession.addEventListener('submit',(e) => {
        e.preventDefault();

        showConfirm('정말 탈퇴하시겠습니까?<br/>이용 내역 및 회원 정보가 영구 삭제됩니다.', () => {
            frmSecession.submit();
        });
    });

    @if ($errors->has('required_check_box'))
        showAlert('안내문 확인 및 회원 정보 삭제에<br/>동의해주시길 바랍니다.');
    @endif
@endsection
