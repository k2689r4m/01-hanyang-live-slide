@extends('backup.layouts.app')

@section('content')
    <classes_professor_view :user="{{ auth()->user() }}" :room-id="{{ $classes['id'] }}" ></classes_professor_view>
@endsection
