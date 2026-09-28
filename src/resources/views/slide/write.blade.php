@extends('layout.slide_layout')

@section('title')
    new slide
@endsection


@section('content')
    <div class="slide_vue new-slide">
        <write_slide :lecture-id="{{ $lecture_id }}" :class-id="{{$class_id}}" :pro-url='@json($user_url)'></write_slide>
    </div>
@endsection
