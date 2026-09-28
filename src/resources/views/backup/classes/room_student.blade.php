@extends('backup.layouts.app')

@section('content')
    <classes_student_room :user="{{ auth()->user() }}" :room-id="{{ $classes['id'] }}" :admin-email="{{ json_encode($classes['user_id']) }}" ></classes_student_room>
@endsection
