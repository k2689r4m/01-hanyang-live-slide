@extends('layout.layout')


@section('title')
    login
@endsection


@section('register.script')
    const confirmModal = document.getElementById("confirm-modal");

    function showConfirmModal() { confirmModal.classList.remove('dn'); }

    confirmModal.querySelector("#confirm-modal-ok").addEventListener("click", () => {
        confirmModal.classList.add("dn");
    });
    
    @if($errors->any())
        showConfirmModal();
    @endif
@endsection


@section('modal.content')
    @if($errors->any())
        {!! nl2br($errors->first()) !!}
    @endif
@endsection


@section('content')
    <div class="dim dn" id="confirm-modal">
        <div class="alert pf">
            <div class="alert__con">
                @if($errors->any())
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
    <div class="bg-white">
        <!-- compact header -->
{{--        <header class="comp-header">--}}
{{--            <h1 class="comp-header__logo">로고</h1>--}}
{{--        </header>--}}
        <!-- //compact header -->

        <!-- join -->
        <div class="content__wrap white">
            <div class="content">
                <h2 class="content__tit">회원가입</h2>
                <div class="input-box">
                    <form method="post" action="{{ route('user.register') }}">
                        @csrf
                        <h3 class="input-box__tit">정보수집, 약관 동의</h3>
                        <label class="checkbox required">
                            <input type="checkbox" name="agree1" {{ old('agree1') ? 'checked' : '' }}/>
                            이용약관 동의
                        </label>
                        <div class="txt-box sm">
                            <p class="txt">예시글입니다.<br><br><br><br><br><br><br><br><br><br><br></p>
                        </div>
                        <label class="checkbox required">
                            <input type="checkbox" name="agree2" {{ old('agree2') ? 'checked' : '' }}/>
                            정보수집 동의
                        </label>
                        <div class="txt-box sm">
                            <p class="txt">예시글입니다.</p>
                        </div>

                        <div class="input-box__input">
                            <label class="input-box__label required" >이메일 </label>
                            <input @if($errors->has('email')) class="line" @endif type="text" placeholder="user01@gmail.com" name="email" value="{{ $socialUser ? $socialUser['email'] : old('email') }}" {{ $socialUser ? 'readonly' : '' }} />
                            @if($errors->has('email'))<p class="input-box__guide">{{ $errors->first('email') }}</p>@endif
                        </div>
                        <div class="input-box__input">
                            <label class="input-box__label required">핸드폰 번호 </label>
                            <input @if($errors->has('contact')) class="line" @endif type="text" placeholder="01012345678" name="contact" value="{{ old('contact') }}" />
                            @if($errors->has('contact'))<p class="input-box__guide">{{ $errors->first('contact') }}</p>@endif
                        </div>
                        <div class="input-box__input">
                            <label class="input-box__label required">비밀번호 </label>
                            <input @if($errors->has('password')) class="line" @endif type="password" placeholder="비밀번호를 입력해주세요." name="password"
                                   value="{{ $socialUser ? '#Kk45678' : '' }}" {{ $socialUser ? 'readonly' : '' }} />
                            @if($errors->has('password'))<p class="input-box__guide">{{ $errors->first('password') }}</p>@endif
                        </div>
                        <div class="input-box__input">
                            <label class="input-box__label required">비밀번호 확인 </label>
                            <input type="password" placeholder="비밀번호를 다시한번 입력해주세요." name="password_confirmation"
                                   value="{{ $socialUser ? '#Kk45678' : '' }}" {{ $socialUser ? 'readonly' : '' }} />
                        </div>
                        <div class="input-box__input">
                            <label class="input-box__label required">이름 </label>
                            <input @if($errors->has('name')) class="line" @endif type="text" placeholder="홍길동" name="name" value="{{ old('name') }}"/>
                            @if($errors->has('name'))<p class="input-box__guide">{{ $errors->first('name') }}</p>@endif
                        </div>
                        <div class="input-box__input">
                            <label class="input-box__label required">닉네임 </label>
                            <input @if($errors->has('nickname')) class="line" @endif type="text" placeholder="길동" name="nickname" value="{{ old('nickname') }}"/>
                            @if($errors->has('nickname'))<p class="input-box__guide">{{ $errors->first('nickname') }}</p>@endif
                        </div>
                        <div class="input-box__input">
                            <label class="input-box__label required">성별 </label>
                            <label class="radio">
                                <input type="radio" name="gender" value="1" {{ old('gender') === '1' ? 'checked' : '' }} />남
                            </label>
                            <label class="radio">
                                <input type="radio" name="gender" value="2" {{ old('gender') === '2' ? 'checked' : '' }} />여
                            </label>
                            @if($errors->has('gender'))<p class="input-box__guide">{{ $errors->first('gender') }}</p>@endif
                        </div>
                        <div class="input-box__input">
                            <label class="input-box__label required">생년월일 </label>
                            <input @if($errors->has('birthday')) class="line" @endif type="text" placeholder="19910101" name="birthday" value="{{ old('birthday') }}"/>
                            @if($errors->has('birthday'))<p class="input-box__guide">{{ $errors->first('birthday') }}</p>@endif
                        </div>
                        <div class="a-center">
                            <button type="submit" class="btn-normal col2 btn-round btn-primary">회원가입</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- //join -->
    </div>
@endsection

{{--<form method="post" action="{{ route('user.register') }}">--}}
{{--    @csrf--}}
{{--    <div class="content__wrap white">--}}
{{--        <div class="content">--}}
{{--            <h2 class="content__tit">회원가입</h2>--}}
{{--            <div class="input-box">--}}
{{--                <h3 class="input-box__tit">정보수집, 약관 동의</h3>--}}
{{--                <label class="checkbox required">--}}
{{--                    <input type="checkbox" name="agree1" {{ old('agree1') ? 'checked' : '' }}/>--}}
{{--                    이용약관 동의--}}
{{--                </label>--}}
{{--                <div class="txt-box sm">--}}
{{--                    <p class="txt">예시글입니다.<br><br><br><br><br><br><br><br><br><br><br></p>--}}
{{--                </div>--}}
{{--                <label class="checkbox required">--}}
{{--                    <input type="checkbox" name="agree2" {{ old('agree2') ? 'checked' : '' }}/>--}}
{{--                    정보수집 동의--}}
{{--                </label>--}}
{{--                <div class="txt-box sm">--}}
{{--                    <p class="txt">예시글입니다.</p>--}}
{{--                </div>--}}
{{--                <h3 class="input-box__tit">회원정보</h3>--}}
{{--                <div class="input-box__input">--}}
{{--                    <label class="input-box__label required" >이메일 </label>--}}
{{--                    <input @if($errors->has('email')) class="line" @endif type="text" placeholder="user01@gmail.com" name="email" value="{{ $socialUser ? $socialUser['email'] : old('email') }}" {{ $socialUser ? 'readonly' : '' }} />--}}
{{--                    @if($errors->has('email'))<p class="input-box__guide">{{ $errors->first('email') }}</p>@endif--}}
{{--                </div>--}}
{{--                <div class="input-box__input">--}}
{{--                    <label class="input-box__label required">핸드폰 번호 </label>--}}
{{--                    <input @if($errors->has('contact')) class="line" @endif type="text" placeholder="01012345678" name="contact" value="{{ old('contact') }}" />--}}
{{--                    @if($errors->has('contact'))<p class="input-box__guide">{{ $errors->first('contact') }}</p>@endif--}}
{{--                </div>--}}
{{--                <div class="input-box__input">--}}
{{--                    <label class="input-box__label required">비밀번호 </label>--}}
{{--                    <input @if($errors->has('password')) class="line" @endif type="password" placeholder="비밀번호를 입력해주세요." name="password" />--}}
{{--                    @if($errors->has('password'))<p class="input-box__guide">{{ $errors->first('password') }}</p>@endif--}}
{{--                </div>--}}
{{--                <div class="input-box__input">--}}
{{--                    <label class="input-box__label required">비밀번호 확인 </label>--}}
{{--                    <input type="password" placeholder="비밀번호를 다시한번 입력해주세요." name="password_confirmation" />--}}
{{--                </div>--}}
{{--                <div class="input-box__input">--}}
{{--                    <label class="input-box__label required">이름 </label>--}}
{{--                    <input @if($errors->has('name')) class="line" @endif type="text" placeholder="홍길동" name="name" value="{{ old('name') }}"/>--}}
{{--                    @if($errors->has('name'))<p class="input-box__guide">{{ $errors->first('name') }}</p>@endif--}}
{{--                </div>--}}
{{--                <div class="input-box__input">--}}
{{--                    <label class="input-box__label required">닉네임 </label>--}}
{{--                    <input @if($errors->has('nickname')) class="line" @endif type="text" placeholder="길동" name="nickname" value="{{ old('nickname') }}"/>--}}
{{--                    @if($errors->has('nickname'))<p class="input-box__guide">{{ $errors->first('nickname') }}</p>@endif--}}
{{--                </div>--}}
{{--                <div class="input-box__input">--}}
{{--                    <label class="input-box__label required">성별 </label>--}}
{{--                    <label class="radio">--}}
{{--                        <input type="radio" name="gender" value="1" {{ old('gender') === '1' ? 'checked' : '' }}/>남--}}
{{--                    </label>--}}
{{--                    <label class="radio">--}}
{{--                        <input type="radio" name="gender" value="2" {{ old('gender') === '2' ? 'checked' : '' }} />여--}}
{{--                    </label>--}}
{{--                </div>--}}
{{--                <div class="input-box__input">--}}
{{--                    <label class="input-box__label required">생년월일 </label>--}}
{{--                    <input @if($errors->has('birthday')) class="line" @endif type="text" placeholder="19910101" name="birthday" value="{{ old('birthday') }}"/>--}}
{{--                    @if($errors->has('birthday'))<p class="input-box__guide">{{ $errors->first('birthday') }}</p>@endif--}}
{{--                </div>--}}
{{--                <div class="a-center">--}}
{{--                    <button type="submit" class="btn-normal col2 btn-round btn-primary">회원가입</button>--}}
{{--                </div>--}}
{{--                    {{ $errors }}--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</form>--}}











{{--Register<br/>--}}
{{--<form>--}}
{{--    <input type="text" name="email" placeholder="email" value="{{ $socialUser ? $socialUser['email'] : old('email') }}" {{ $socialUser ? 'readonly' : '' }} /><br/>--}}
{{--    <input type="text" name="contact" placeholder="contact" value="{{ old('contact') }}" /><br/>--}}
{{--    <input type="text" name="password" placeholder="password" /><br/>--}}
{{--    <input type="text" name="password_confirmation" placeholder="password_confirm"  /><br/>--}}
{{--    <input type="text" name="name" placeholder="name" value="{{ old('name') }}" /><br/>--}}
{{--    <input type="text" name="nickname" placeholder="nickname" value="{{ old('nickname') }}" /><br/>--}}
{{--    <input type="radio" name="gender" value="1" {{ old('gender') === 1 ? 'checked' : '' }} />male<br/>--}}
{{--    <input type="radio" name="gender" value="2" {{ old('gender') === 2 ? 'checked' : '' }} />female<br/>--}}
{{--    <input type="text" name="birthday" placeholder="birthday" value="{{ old('birthday') }}" /><br/>--}}
{{--    <button type="submit">Register</button>--}}
{{--</form>--}}
