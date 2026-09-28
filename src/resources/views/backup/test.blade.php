
@extends('backup.layouts.app')

@section('content')
    <div name="this div for just test" style="display: flex;justify-content: center;align-items: center;border: 1px solid black;height: 100%;width: 100%;">
        <graph :width="`100%`" :height="`100%`" :type="`word_cloud`" :data="[{name: 'test1', value: 8}, {name: 'test2', value: 2}, {name: 'test3', value: 17}, {name: 'test4', value: 4}]"></graph>
    </div>
@endsection

