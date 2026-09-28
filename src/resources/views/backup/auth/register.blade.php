@extends('backup.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="container">
                        <div class="col-sm agree-sub-title">정보수집, 약관 동의</div>
                        <div class="row">
                            <div class="col-sm">
                                <nav id="navbar-example2" class="navbar navbar-light bg-light">
                                    <input class="@error('agree1') is-invalid @enderror" type="checkbox" name="agree1" id="agree1" value="agree1" required> 이용약관 동의 <span class="text-co">*</span>
                                </nav>
                                <div data-spy="scroll" data-target="#navbar-example2" data-offset="0">
                                    <p class="agree-scroll">이용약관 동의이용약관 동의이용약관 동의이용약관 동의이용약관 동의이용약관 동의이용약관 동의이용약관 동의이용약관 동의이용약관 동의이용약관 동의이용약관 동의이용약관 동의이용약관 동의이용약관 동의이용약관 동의이용약관 동의이용약관 동의이용약관 동의이용약관 동의이용약관 동의이용약관 동의이용약관 동의이용약관 동의이용약관 동의이용약관 동의이용약관 동의이용약관 동의이용약관 동의이용약관 동의이용약관 동의이용약관 동의이용약관 동의</p>
                                </div>
                                @error('agree1')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-sm">
                                <nav id="navbar-example2" class="navbar navbar-light bg-light">
                                    <input class="@error('agree2') is-invalid @enderror" type="checkbox" name="agree2" id="agree2" value="agree2" required> 정보수집 동의 <span class="text-co">*</span>
                                </nav>
                                <div data-spy="scroll" data-target="#navbar-example2" data-offset="0">
                                    <p class="agree-scroll">정보수집 동의정보수집 동의정보수집 동의정보수집 동의정보수집 동의정보수집 동의정보수집 동의정보수집 동의정보수집 동의정보수집 동의정보수집 동의정보수집 동의정보수집 동의정보수집 동의정보수집 동의정보수집 동의정보수집 동의정보수집 동의정보수집 동의정보수집 동의정보수집 동의정보수집 동의정보수집 동의정보수집 동의정보수집 동의정보수집 동의정보수집 동의정보수집 동의정보수집 동의정보수집 동의정보수집 동의정보수집 동의정보수집 동의정보수집 동의정보수집 동의정보수집 동의정보수집 동의정보수집 동의</p>
                                </div>
                                @error('agree2')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="agree-sub-title">정보수집, 약관 동의</div>

                    <div class="col-sm">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputEmail4">이메일 *</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="ID@email.com" required>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputPassword4">휴대폰번호 *</label>
                                <input type="text" class="form-control @error('contact') is-invalid @enderror" id="phone" name="contact" placeholder="01012341234" required>
                                @error('contact')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputPassword4">비밀번호 *</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="영문/숫자 혼합 6-12 글자" required>
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputPassword4">비밀번호 확인 *</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password_confirmation" name="password_confirmation" required>
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputPassword4">이름 *</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" required>
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputPassword4">닉네임 *</label>
                                <input type="text" class="form-control @error('nickname') is-invalid @enderror" id="nickname" name="nickname" placeholder="규칙" required>
                                @error('nickname')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputPassword4">성별 *</label>
                                <div class="container">
                                    <div class="row">
                                        <div class="form-check form-check-inline col-sm">
                                            <input class="form-check-input @error('gender') is-invalid @enderror" type="radio" name="gender" id="male" value="1" required>
                                            <label class="form-check-label" for="inlineRadio1">남</label>
                                        </div>
                                        <div class="form-check form-check-inline col-sm">
                                            <input class="form-check-input @error('gender') is-invalid @enderror" type="radio" name="gender" id="female" value="2" required>
                                            <label class="form-check-label" for="inlineRadio2">여</label>
                                        </div>
                                    </div>
                                    @error('gender')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputPassword4">생년월일 *</label>
                                <input type="password" class="form-control @error('birthday') is-invalid @enderror" id="birthday" name="birthday" placeholder="19900530" required>
                                @error('birthday')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row justify-content-md-center submit-from">
                            <button class="btn btn-primary" type="submit">회원 가입</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
