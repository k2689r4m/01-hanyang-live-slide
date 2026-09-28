<!-- 3단길이의 첫번째 열 -->
<div class="col-md-2">
    <!-- 사이드 바 메뉴-->
    <!-- 패널 타이틀1 -->
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">내 강의실</h3>
        </div>
        <!-- 사이드바 메뉴목록1 -->
        <ul class="list-group">
            @foreach($host as $h)

                <li class="list-group-item">
                    @if ($lecture_id == $h->id)
                        <strong style="color: orangered;">
                    @endif
                        T
                    @if ($lecture_id == $h->id)
                        </strong>
                    @endif
                    <a href="/classes/{{ $h->id }}">{{ $h->name }}</a>
                    @if ($lecture_id == $h->id)
                        <ul class="list-group list-group-flush" style="cursor: pointer;">
                            <li class="list-group-item h6 small active" id="_progress">X주차 진행 중</li>
                            <li class="list-group-item h6 small" id="_notice">공지사항</li>
                            <li class="list-group-item h6 small" id="_file">자료실(서랍)</li>
                            <li class="list-group-item h6 small" id="_ask">질문답변</li>
                        </ul>
                    @endif
                </li>

            @endforeach
            @foreach($guest as $g)

                <li class="list-group-item">
                    @if ($lecture_id == $g['lecture']->id)
                        <strong style="color: orangered;">
                    @endif
                        S
                    @if ($lecture_id == $g['lecture']->id)
                        </strong>
                    @endif
                    <a href="/classes/{{ $g['lecture']->id }}">{{ $g['lecture']->name }}</a>
                    @if ($lecture_id == $g['lecture']->id)
                            <ul class="list-group list-group-flush" style="cursor: pointer;">
                                <li class="list-group-item h6 small active" id="_progress">X주차 진행 중</li>
                                <li class="list-group-item h6 small" id="_notice">공지사항</li>
                                <li class="list-group-item h6 small" id="_file">자료실(서랍)</li>
                                <li class="list-group-item h6 small" id="_ask">질문답변</li>
                            </ul>
                    @endif
                </li>

            @endforeach
        </ul>
    </div>
</div>
