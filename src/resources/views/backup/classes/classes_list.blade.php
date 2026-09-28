<table class="table">
    <thead>
    <tr>
        <th>No</th>
        <th>수업명</th>
        <th>참여자 수</th>
        <th>수업 링크 복사</th>
        <th>다시보기 링크 복사</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    @foreach($classes as $cls)
        <tr>
            <td style="vertical-align: inherit;">{{ $cls['id'] }}</td>
            <td style="vertical-align: inherit;">{{ $cls['name'] }}</td>
            <td style="vertical-align: inherit;">x명/{{ $member_count }}명</td>
            <td style="vertical-align: inherit;">{{ $cls['active_start_date'] }} ~ {{ $cls['active_end_date'] }}</td>
            <td style="vertical-align: inherit;">{{ $cls['record_start_date'] }} ~ {{ $cls['record_end_date'] }}</td>

            <td class="row" style="vertical-align: inherit;">
                @if(auth()->user()->email == $cls['user_email'])
                    <button class="col-sm-6 btn btn-secondary" onclick="window.location='{{ $lecture_id }}/room/{{$cls['id']}}'" type="button">시작하기</button>
                    <button class="col-sm-3 btn btn-secondary" onclick="window.location='edit/{{ $lecture_id }}/{{$cls['id']}}'" type="button" >설정</button>
                    <button class="col-sm-3 btn btn-secondary generalDonation" type="submit" onClick="modal_up({{ $lecture_id }} , {{$cls['id']}})" data-toggle="modal" data-keyboard="false" data-target="#myModalHorizontal">삭제</button>
                @else
                    <button class="col-sm-6 btn btn-secondary" onclick="window.location='{{ $lecture_id }}/room/{{$cls['id']}}'" type="button" >입장하기</button>
                    <button class="col-sm-6 btn btn-secondary" type="button" >다시보기</button>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
