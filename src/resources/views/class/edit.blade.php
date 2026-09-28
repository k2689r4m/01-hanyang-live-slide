<form method="post" action="{{ route('class.edit',['lecture_id' => $lecture_id, 'class_id' => $class_id]) }}">
    @csrf
    Class Edit<br/>
    <input type="text" name="name" placeholder="수업명" value="{{ old("name") ?? $class->name }}" /><br/>
    <input type="text" name="user_url" placeholder="수업 URL" value="{{ old("user_url") ?? $class->user_url }}" /><br/>

    <input type="radio" name="active_always" value="0" @if ($class->active_always === 0) checked @endif />
    <input type="radio" name="active_always" value="1" @if ($class->active_always === 1) checked @endif />
    <input type="radio" name="active_always" value="2" @if ($class->active_always === 2) checked @endif /><br>
    <input type="text" name="active_start_date" placeholder="active_start_date" value="{{ old("active_start_date") ?? $class->active_start_date }}" /><br>
    <input type="text" name="active_end_date" placeholder="active_end_date" value="{{ old("active_end_date") ?? $class->active_end_date }}" /><br>

    <input type="radio" name="record_always" value="0" @if ($class->record_always === 0) checked @endif />
    <input type="radio" name="record_always" value="1" @if ($class->record_always === 1) checked @endif />
    <input type="radio" name="record_always" value="2" @if ($class->record_always === 2) checked @endif /><br>
    <input type="text" name="record_start_date" placeholder="record_start_date" value="{{ old("record_start_date") ?? $class->record_start_date }}" /><br>
    <input type="text" name="record_end_date" placeholder="record_end_date" value="{{ old("record_end_date") ?? $class->record_end_date }}" /><br>

    <button type="button" onclick="history.back()">취소</button>
    <button type="submit">시작</button>
</form>
