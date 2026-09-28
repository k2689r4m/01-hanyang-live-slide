@extends('layout.layout')

@section('title')
    마이페이지
@endsection

@isset($state)
    {{$state}}
    <script>
        window.onload = () => {
            alert('{{ $state}}');
            location.href = "{{ route('user.myInfoView') }}";
        }
    </script>
@endisset

@section('content')
    <div class="dim dn" id="myInfoAlert">
        <div class="alert">
            <div class="alert__con"></div>
            <div class="alert__bottom">
                <div class="alert__btn-wrap">
                    <button class="alert__btn primary ok-btn">확인</button>
                </div>
            </div>
        </div>
    </div>
    <div class="dim dn" id="myInfoConfirm">
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
            <li class="page-nav__item home cp" onclick="location.href='{{ route('lecture.mainView') }}'"></li>
            <li class="page-nav__item cp " onclick="location.href=`{{ route('user.myInfoView') }}`">개인정보</li>
        </ul>
    </div>
    <div class="content__wrap exist-nav exist-leftmenu">
        <div class="content">
            <h2 class="content__tit">개인정보</h2>
            <!-- input box -->
            <div class="input-box input-txt-lg my-info">
                <form method="post" action="{{ route('user.myInfoChange') }}" id="frmNicknameChange">
                    @csrf
                    <h3 class="input-box__tit">회원정보</h3>
                    <div class="input-box__input">
                        <label class="input-box__label">이름 </label>
                        <input type="text" name="name" value="{{ $user->name }}" readonly />
                    </div>
                    <div class="input-box__input">
                        <label class="input-box__label">이메일 </label>
                        <input type="text" name="email" value="{{ $user->email }}" readonly />
                    </div>
                    <div class="input-box__input">
                        <label class="input-box__label">닉네임 </label>
                        <input class="col-6" type="text" name="nickname" value="{{ $user->nickname }}" />
                        <button class="btn-primary btn-line btn-normal">변경</button>
                    </div>
                </form>
                <form method="post" action="{{ route('user.myInfoChange') }}" id="frmPasswordChange">
                    @csrf
                    <h3 class="input-box__tit">비밀번호 변경</h3>
                    <div class="input-box__input">
                        <label class="input-box__label required">비밀번호 </label>
                        <input @if($errors->has('password')) class="line" @endif type="password" placeholder="password" name="password" />
                        @if($errors->has('password'))<p class="input-box__guide">{{ $errors->first('password') }}</p>@endif
                    </div>
                    <div class="input-box__input">
                        <label class="input-box__label required">새 비밀번호 </label>
                        <input @if($errors->has('password')) class="line" @endif type="password" placeholder="new password" name="new_password" />
                        @if($errors->has('password'))<p class="input-box__guide">{{ $errors->first('password') }}</p>@endif
                    </div>
                    <div class="input-box__input">
                        <label class="input-box__label required">새 비밀번호 확인 </label>
                        <input @if($errors->has('new_password_confirmation')) class="line" @endif type="password" placeholder="new password confirm" name="new_password_confirmation" />
                        @if($errors->has('new_password_confirmation'))<p class="input-box__guide">{{ $errors->first('new_password_confirmation') }}</p>@endif
                    </div>
                    <div class="a-center">
                        <button class="btn-normal col2 btn-round btn-primary">변경</button>
                    </div>
                    <h3 class="input-box__tit">회원탈퇴</h3>
                    <div class="input-box__input">
                        <label class="input-box__label">탈퇴 </label>
                        <a href="{{ route('user.secessionView') }}" class="btn btn-primary btn-line btn-normal">회원 탈퇴</a>
                    </div>
                </form>
            </div>
            <!-- //input box -->
        </div>
    </div>
@endsection
@section('user.myinfo.script')
    const frmNicknameChange = document.querySelector('#frmNicknameChange');
    const frmPasswordChange = document.querySelector('#frmPasswordChange');

    function showAlert(content, okCallback) {
        const alert = document.getElementById('myInfoAlert');
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
        const confirm = document.getElementById('myInfoConfirm');
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

    frmNicknameChange.addEventListener('submit',(e) => {
        e.preventDefault();

        showConfirm('닉네임을 변경하시겠습니까?', () => {
            frmNicknameChange.submit();
        });
    });

    frmPasswordChange.addEventListener('submit',(e) => {
        e.preventDefault();

        showConfirm('비밀번호를 변경하시겠습니까?', () => {
            frmPasswordChange.submit();
        });
    });

    @if (Session::has('NICKNAME_CHANGED'))
        showAlert('닉네임이 변경되었습니다.');
    @elseif (Session::has('INCORRECT_PASSWORD'))
        showAlert('입력하신 비밀번호가 일치하지 않습니다.');
    @elseif (Session::has('PASSWORD_CHANGED'))
        showAlert('비밀번호가 변경되었습니다.', () => location.href='{{ route('user.logout') }}');
    @elseif ($errors->any())
        showAlert('{{$errors->first()}}');
    @endif
@endsection
