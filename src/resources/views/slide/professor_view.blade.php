@extends('layout.slide_layout')

@section('title')
    new slide
@endsection

<style>
    .domain {
        stroke: #d5d5de;
        stroke-width: 0.7px;
        /**/
        /*opacity: 0;*/
    }

    line {
        opacity: 0;
    }

    svg {
        -webkit-touch-callout: none;
        -webkit-user-select: none;
        -khtml-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }
</style>

@section('content')
<div class="slide_vue">
    <professor
        :room-id="{{$class_id}}"
        :lecture-id="{{$lecture_id}}"
        :pagination="{{json_encode($pagination)}}"
        :pro-id="{{auth()->id()}}"
        :pro-url='@json($user_url)'
        :check-right='@json(URL::asset('img/checkRight.png'))'
        :check-wrong='@json(URL::asset('img/checkWrong.png'))'
        :check-wrong-disable='@json(URL::asset('img/checkWrongDisable.png'))'
    ></professor>
</div>
@endsection
