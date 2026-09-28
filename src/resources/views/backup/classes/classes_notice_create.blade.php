<form class="col-sm-10" method="POST" action="{{ route('classes.notice.submit') }}">
    @csrf
    <input type="hidden" name="lecture_id" vlaue="{{ $lecture_id }}" />
    <div>
        공지사항 등록
    </div>
    <hr>
    <div class="row">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default">* 제목</span>
            </div>
            <input id="notice-title" type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" name="title">
        </div>
    </div>
    <div class="row">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text">* 내용</span>
            </div>
            <textarea id="notice-content" class="form-control" aria-label="With textarea" name="content"></textarea>
        </div>
    </div>
    <div id="notice-files" class="row">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text">* 첨부파일</span>
            </div>
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="inputGroupFile01" name="file">
                <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
            </div>
            <div class="input-group-append">
                <button id="notice-file-add" class="btn btn-outline-secondary" type="button" name="notice-file-add">+</button>
                <button id="notice-file-delete" class="btn btn-outline-secondary" type="button" name="notice-file-delete">-</button>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end">
        <button id="notice-clear" class="btn btn-secondary mr-3" type="button">내용 비우기</button>
        <button class="btn btn-secondary">등록</button>
    </div>
</form>

