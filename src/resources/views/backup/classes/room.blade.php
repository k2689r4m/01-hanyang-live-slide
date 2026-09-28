@extends('backup.layouts.app')

@section('content')
    <classes_room :user="{{ auth()->user() }}" :room-id="{{ $classes['id'] }}"></classes_room>

@endsection
