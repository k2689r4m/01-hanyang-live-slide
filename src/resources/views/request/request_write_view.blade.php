@extends('layout.request_layout')

@section('title')
    문의사항
@endsection

@section('content')
    <div class="bg-white">
        <!-- join -->
        <div class="content__wrap white exist-nav">
            <ul class="page-nav gray">
                <li class="page-nav__item home cp" onclick="location.href=`{{ route('lecture.mainView') }}`"></li>
                <li class="page-nav__item cp" onclick="location.href=`{{ route('request.writeView') }}`">문의</li>
            </ul>
            <div class="content">
                <h2 class="content__tit mt-0">문의</h2>
                <p class="content__guide">문의사항이 있으신가요? 저희에게 알려주세요.</p>
                <div class="input-box input-txt-lg">
                    <form method="post" action="{{ route('request.write') }}">
                        @csrf
                        <div class="input-box__input">
                            <label class="input-box__label required">이메일 </label>
                            <input @if($errors->has('email')) class="line" @endif type="text" placeholder="답변받을 이메일을 입력해주세요." name="email" value="{{ old('email') ?? '' }}" />
                            @if($errors->has('email'))<p class="input-box__guide">{{ $errors->first('email') }}</p>@endif
                        </div>
                        <div class="input-box__input">
                            <label class="input-box__label required">이름 </label>
                            <input @if($errors->has('name')) class="line" @endif type="text" placeholder="이름을 입력해주세요." name="name" value="{{ old('name') ?? '' }}" />
                            @if($errors->has('name'))<p class="input-box__guide">{{ $errors->first('name') }}</p>@endif
                        </div>
                        <div class="input-box__input">
                            <label class="input-box__label required">문의 제목 </label>
                            <input @if($errors->has('title')) class="line" @endif type="text" placeholder="문의 제목을 입력해주세요." name="i_tit" value="{{ old('title') ?? '' }}" />
                            @if($errors->has('title'))<p class="input-box__guide">{{ $errors->first('title') }}</p>@endif
                        </div>
                        <div class="input-box__input">
                            <label class="input-box__label required">문의 내용 </label>
                            <textarea @if($errors->has('content')) class="line" @endif name="i_con" placeholder="문의 내용을 입력해주세요." rows="15">{{ old('content') ?? '' }}</textarea>
                            @if($errors->has('content'))<p class="input-box__guide">{{ $errors->first('content') }}</p>@endif
                        </div>
                        <div class="input-box__input">
                            <label class="checkbox">
                                <input type="checkbox" value="use_nick" @if(!!old('required_check_box')) checked @endif />(필수) 개인정보 수집에 동의합니다.
                            </label>
                        </div>
                        <div class="a-center p-30">
                            <button type="submit" class="btn-normal col2 btn-round btn-primary">등록</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- //join -->
    </div>
@endsection
