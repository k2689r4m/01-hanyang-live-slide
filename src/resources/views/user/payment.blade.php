@extends('layout.layout')

@section('title')
    요금제
@endsection

@section('content')
    <div class="page-nav-wrap">
        <ul class="page-nav gray">
            <li class="page-nav__item home"></li>
            <li class="page-nav__item">내정보</li>
            <li class="page-nav__item">요금제</li>
        </ul>
    </div>
    <div class="content__wrap exist-nav exist-leftmenu round">
        <div class="content">
            <h2 class="content__tit">요금제<br><img src="../images/logo.png" alt="logo" /></h2>
            <!-- 요금제 -->
            <ul class="product-list">
                <li class="product-list__item">
                    <h3 class="name">Pro</h3>
                    <div class="price"><span class="month">매 달</span><span class="num">7,500</span>원</div>
                    <div class="intro">대표 기능 설명 입니다.<br>대표 기능 설명 입니다.
                        <button class="btn-sm btn-primary btn-round">시작하기</button>
                    </div>
                    <ul class="intro-list">
                        <li class="intro-list__item">서비스 설명 입니다.</li>
                        <li class="intro-list__item">서비스 설명 입니다.</li>
                        <li class="intro-list__item">서비스 설명 입니다.</li>
                        <li class="intro-list__item">서비스 설명 입니다.</li>
                    </ul>
                </li>
                <li class="product-list__item use">
                    <h3 class="name">Pro</h3>
                    <div class="price"><span class="month">매 달</span><span class="num">7,500</span>원</div>
                    <div class="intro">대표 기능 설명 입니다.<br>대표 기능 설명 입니다.
                        <button class="btn-sm btn-primary btn-round btn-line">멤버십 해지</button>
                    </div>
                    <ul class="intro-list">
                        <li class="intro-list__item">서비스 설명 입니다.</li>
                        <li class="intro-list__item">서비스 설명 입니다.</li>
                        <li class="intro-list__item">서비스 설명 입니다.</li>
                        <li class="intro-list__item">서비스 설명 입니다.</li>
                    </ul>
                </li>
                <li class="product-list__item">
                    <h3 class="name">Pro</h3>
                    <div class="price"><span class="month">매 달</span><span class="num">7,500</span>원</div>
                    <div class="intro">대표 기능 설명 입니다.<br>대표 기능 설명 입니다.
                        <button class="btn-sm btn-primary btn-round">시작하기</button>
                    </div>
                    <ul class="intro-list">
                        <li class="intro-list__item">서비스 설명 입니다.</li>
                        <li class="intro-list__item">서비스 설명 입니다.</li>
                        <li class="intro-list__item">서비스 설명 입니다.</li>
                        <li class="intro-list__item">서비스 설명 입니다.</li>
                    </ul>
                </li>
                <li class="product-list__item">
                    <h3 class="name">Pro</h3>
                    <div class="price"><span class="month">매 달</span><span class="num">7,500</span>원</div>
                    <div class="intro">대표 기능 설명 입니다.<br>대표 기능 설명 입니다.
                        <button class="btn-sm btn-primary btn-round">시작하기</button>
                    </div>
                    <ul class="intro-list">
                        <li class="intro-list__item">서비스 설명 입니다.</li>
                        <li class="intro-list__item">서비스 설명 입니다.</li>
                        <li class="intro-list__item">서비스 설명 입니다.</li>
                        <li class="intro-list__item">서비스 설명 입니다.</li>
                    </ul>
                </li>
            </ul>
            <!-- //요금제 -->
        </div>
    </div>
@endsection
