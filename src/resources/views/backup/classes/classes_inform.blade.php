<div>
    <div class="col-sm-12 row">
        <div class="col-sm-6">
            <div>
                과목명
            </div>
            <input class="col-sm-12" type="text" readonly value="{{ $lecture['name'] }}"/>
        </div>
        <div class="col-sm-6">
            <div>
                입장 코드
            </div>
            <input class="col-sm-12" type="text" readonly value="{{ $lecture['lecture_code'] }}" />
        </div>
    </div>
    <div class="col-sm-12">
        <div>
            과목 소개
        </div>
        <input class="col-sm-12" type="text" readonly value="{{ $lecture['description'] }}" />
    </div>
    <div class="col-sm-12">
        <div>
            학습 목표
        </div>
        <input class="col-sm-12" type="text" readonly value="{{ $lecture['lecture_goal_desc'] }}" />
    </div>
    <div class="col-sm-12">
        닉네임 사용
        <input type="checkbox" @if ($lecture['use_nickname']) checked @endif disabled />
    </div>
    <div class="col-sm-12">
        <div>
            주차별 수업 안내
        </div>
        <div class="col-sm-12 row">
            @foreach($lecture['classes'] as $class)
                <input class="col-sm-3" type="text" readonly value="{{ $class->title }}" />
                <input class="col-sm-9" type="text" readonly value="{{ $class->desc }}" />
            @endforeach
        </div>
    </div>
    <div class="col-sm-12">
        <div>
            평가 방법
        </div>
        <div class="col-sm-12 row">
            @foreach($lecture['evaluation'] as $e)
                <input class="col-sm-3" type="text" readonly value="{{ $e->factor }}" />
                <input class="col-sm-9" type="text" readonly value="{{ $e->ratio }}" />
            @endforeach
        </div>
    </div>
</div>
