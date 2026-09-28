@extends('layout.slide_layout')

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

@section('title')
    slide
@endsection


@section('content')
<div class="slide_vue">
    <student
        :room-id="{{$class_id}}"
        :pagination="{{$pagination}}"
        :pro-id="{{$professor_id}}"
        :pro-url='@json($user_url)'
        :user-id="{{auth()->id()}}"
        :check-right='@json(URL::asset('img/checkRight.png'))'
        :check-wrong='@json(URL::asset('img/checkWrong.png'))'
        :check-wrong-disable='@json(URL::asset('img/checkWrongDisable.png'))'
    ></student>
</div>
@endsection
