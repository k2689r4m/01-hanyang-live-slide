@extends('layout.sidebar_layout')

@section('title')
    자료실 상세
@endsection

@section('content')
    <!-- professor board -->
    <div class="page-nav-wrap">
        <ul class="page-nav gray">
            <li class="page-nav__item home cp" onclick="location.href='{{ route('lecture.mainView', ['lecture_id' => $lecture_id]) }}'"></li>
            <li class="page-nav__item cp" onclick="location.href='{{ route('lecture.lectureView', ['lecture_id' => $lecture_id]) }}'">내 강의실</li>
            <li class="page-nav__item cp" onclick="location.href='{{ route('lecture.archiveView', ['lecture_id' => $lecture_id] ) }}'">자료실</li>
            <li class="page-nav__item cp" onclick="location.href='{{ route('lecture.archive.detailView', ['lecture_id' => $lecture_id, 'archive_id' => $archive->id] ) }}'">자료실 상세</li>
        </ul>
    </div>
    <div class="content__wrap exist-nav exist-leftmenu round">
        <div class="content analysis__wrap">
            <h2 class="content__tit board-tit">자료실(서랍)</h2>
            <div class="board-detail">
                <div class="board-detail__tit">
                    <h3 class="tit">{{$archive['title']}}</h3>
                    <span class="date">{{ date('Y.m.d', strtotime($archive['created_at'])) }}</span>
{{--                    <button class="modi" href="{{ route('lecture.archive.editView', ['lecture_id' => $lecture_id, 'archive_id' => $archive['id']]) }}">수정</button>--}}
                    @if (request()->get('isOwn'))
                        <a class="modi" href="{{ route('lecture.archive.editView', ['lecture_id' => $lecture_id, 'archive_id' => $archive['id']]) }}">수정</a><br/>
                    @endif
                </div>

                <div class="board-detail__con">
                    <p class="con">
                        {{$archive['content']}}
                    </p>
                    @foreach($archive['file'] as $file)
                        <div class="download"><a href="{{ route('lecture.archive.download', ['lecture_id' => $lecture_id, 'archive_id' => $archive['id'], 'file_name' => $file->fileName, 'download_name' => $file->fileRealName]) }}">{{$file->fileRealName}}</a></div>
                    @endforeach
                </div>
            </div>
            <div class="a-center p-30">
                <button class="btn-gray btn-line btn-normal btn-round btn-back" onclick="location.href=`{{ route('lecture.archiveView', ['lecture_id' => $lecture_id]) }}`">목록으로</button>
            </div>
        </div>
    </div>
    <!-- //professor board -->
@endsection








{{--자료실 ARCHIVE DETAIL--}}
{{--<p>{{ $archive['title'] }}</p>--}}
{{--<p>{{ $archive ['created_at'] }}</p>--}}
{{--@if (request()->get('isOwn'))--}}
{{--    <a href="{{ route('lecture.archive.editView', ['lecture_id' => $lecture_id, 'archive_id' => $archive['id']]) }}">수정</a><br/>--}}
{{--@endif--}}
{{--<p>{{ $archive['content'] }}</p>--}}
{{--<hr/>--}}
{{--@foreach($archive['file'] as $file)--}}
{{--    <a href="{{ route('lecture.archive.download', ['lecture_id' => $lecture_id, 'archive_id' => $archive['id'], 'file_name' => $file->fileName, 'download_name' => $file->fileRealName]) }}">{{ $file->fileRealName }}</a><br/>--}}
{{--@endforeach--}}
{{--<hr/>--}}
{{--<a href="{{ route('lecture.archiveView', ['lecture_id' => $lecture_id]) }}">목록으로</a>--}}
{{--<p></p>--}}
{{--<p></p>--}}
{{--<p></p>--}}
{{--<p></p>--}}
{{--<p></p>--}}
{{--<p></p>--}}
{{--<p></p>--}}
{{--<p></p>--}}
{{--<p></p>--}}
{{--<p></p>--}}
{{--<p></p>--}}
{{--<p></p>--}}
{{--<p></p>--}}
{{--<p></p>--}}
{{--<p></p>--}}
{{--<p></p>--}}
{{--<p></p>--}}




