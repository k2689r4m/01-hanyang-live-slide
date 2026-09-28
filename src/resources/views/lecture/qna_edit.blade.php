@extends('layout.sidebar_layout')
@section('title')
    질문답변
@endsection


@section('qna.script')
    document.getElementById('qna_file').addEventListener('change', (event) => {
    const files = event.target.files;

    Object.values(files).forEach((file) => {
    const span = document.createElement('span');
    const button = document.createElement('button');

    span.classList.add('attached-file__name');
    span.innerHTML = file.name;

    if (document.getElementById('file_container').lastChild === null) {
    button.name = 0;
    span.name = 0;
    fileList[0] = file;
    }
    else {
    button.name = document.getElementById('file_container').lastChild.name + 1;
    span.name = document.getElementById('file_container').lastChild.name + 1;
    fileList[document.getElementById('file_container').lastChild.name + 1] = file;
    }

    button.type = 'button';
    button.onclick = (e) => {
    fileList.splice(e.target.name * 1, 1, null);
    e.target.parentNode.remove();
    };
    button.classList.add('btn-delete');

    span.appendChild(button);

    document.getElementById('file_container').appendChild(span);
    });
    })
@endsection

<script>
    var fileList = [];
    var existFileList = [];
    @foreach($qna->file as $file)
    existFileList.push(`{{ $file->fileName }}`);
    @endforeach

    const sendData = () => {
        let formData = new FormData();
        formData.append('title', document.getElementById('title').value);
        formData.append('content', document.getElementById('content').value);

        for (let file in fileList) {
            if (fileList[file]) {
                formData.append('file[]', fileList[file]);
            }
        }

        formData.append('existFileList', existFileList);
        if (document.getElementById('lock').checked) {
            formData.append('lock', 0);
        }
        else {
            formData.append('lock', 1);
        }

        var request = new XMLHttpRequest();
        request.open("POST", `${window.location.pathname}`, true);
        request.setRequestHeader('X-CSRF-TOKEN', `{{ csrf_token() }}`);

        request.onload = (oEvent) => {
            if (request.status === 200) {
                //success
                const response = JSON.parse(request.response);

                if (response.hasOwnProperty('status')) {
                    if (response.status === 'success') {
                        document.getElementById('alert_content').innerText = '수정되었습니다.';
                        document.getElementById('alert_confirm').onclick = () => {
                            location.href = response.content;
                        }

                        document.getElementById('alert_dim').classList.remove('dn');
                    }
                    else if (response.status === 'error') {
                        document.getElementById('alert_content').innerText = response.content;
                        document.getElementById('alert_confirm').onclick = () => {
                            document.getElementById('alert_dim').classList.add('dn');
                        }
                        document.getElementById('alert_dim').classList.remove('dn');
                    }
                    else if(response.status === 'error 2') {
                        location.href = response.content;
                    }
                }
            }
            else {
                //fail
                console.log('fail');
            }
        }

        request.send(formData);


    }
</script>

@section('content')
    <div class="dim dn" id="alert_dim">
        <div class="alert" id="alert">
            <div class="alert__con" id="alert_content">
            </div>
            <div class="alert__bottom">
                <div class="alert__btn-wrap">
                    <button class="alert__btn primary" id="alert_confirm">확인</button>
                </div>
            </div>
        </div>
    </div>
    <div class="dim dn" id="alert_cc_dim">
        <div class="alert" id="alert_cc">
            <div class="alert__con" id="alert_cc_content"></div>
            <div class="alert__bottom">
                <div class="alert__btn-wrap">
                    <button class="alert__btn gray" onclick="event.target.parentNode.parentNode.parentNode.parentNode.classList.add('dn')">취소</button>
                </div>
                <div class="alert__btn-wrap">
                    <button class="alert__btn primary" id="alert_cc_confirm">확인</button>
                </div>
            </div>
        </div>
    </div>
    <div class="page-nav-wrap">
        <ul class="page-nav gray">
            <li class="page-nav__item home cp" onclick="location.href='{{ route('lecture.mainView', ['lecture_id' => $lecture_id]) }}'"></li>
            <li class="page-nav__item cp" onclick="location.href='{{ route('lecture.mainView', ['lecture_id' => $lecture_id]) }}'">내 강의실</li>
            <li class="page-nav__item cp" onclick="location.href='{{ route('lecture.qnaView', ['lecture_id' => $lecture_id]) }} '">질문답변</li>
            <li class="page-nav__item cp" onclick="location.href='{{ route('lecture.qna.editView', ['lecture_id' => $lecture_id, 'qna_id' => $qna['id']]) }} '">질문답변 수정</li>
        </ul>
    </div>
    <!-- professor board -->
    <div class="content__wrap exist-nav exist-leftmenu round">
        <div class="content analysis__wrap">
            <h2 class="content__tit board-tit">질문답변</h2>
            <div class="input-box board">
                <form>
                    @csrf
                    <div class="input-box__input">
                        <label type="text"  class="input-box__label required">제목 </label>
                        <input type="text" name="title" id="title" value="{{ $qna->title }}" placeholder="제목을 입력하세요." name="sub" />
                    </div>
                    <div class="input-box__input">
                        <label class="input-box__label required">내용 </label>
                        <textarea id="content" placeholder="내용을 입력하세요." name="content" rows="10">{{ $qna->content }}</textarea>
                    </div>
                    <div class="input-box__input">


                        <label class="input-box__label">첨부파일</label>
                        <ul class="attached-file">
                            <li class="attached-file__item">
                                <label class="btn btn-normal btn-round btn-primary btn-line mr-10">파일 찾기
                                    <input id='qna_file' type="file" id="fileUpload" multiple />
                                </label>
                                <span id="exist_file_container">
                                    @for($i = 0;$i < count($qna->file);$i++)
                                        <span class="attached-file__name" name="{{ $i }}">
                                            {{ $qna->file[$i]->fileRealName }}
                                            <button class="btn-delete" type="button" name="{{ $i }}" onclick="
                                                existFileList.splice(event.target.name * 1, 1, null);
                                                event.target.parentNode.remove();
                                        "></button>
                                        </span>
                                    @endfor
                                <span id="file_container"></span>
                                </span>
                            </li>
                        </ul>
                    </div>
                    <div class="input-box__input">
                        <label
                                class="input-box__label required"
                        >질문답변
                        </label>
                        <label class="radio">
                            <input
                                    id="lock"
                                    type="radio"
                                    name="lock"
                                    value="0"
                                    checked
                            />공개
                        </label>
                        <label class="radio">
                            <input
                                    type="radio"
                                    name="lock"
                                    value="1"
                            />비공개
                        </label>
                    </div>
                    <div class="a-center p-30 pt-0">
                        <button class="btn-normal col2 btn-gray btn-line btn-round mr-20" type="button" onclick="
                                document.getElementById('alert_cc_dim').classList.remove('dn');
                                document.getElementById('alert_cc_content').innerHTML = `
                                    해당 페이지에서 나가시겠습니까?<br>
                                    작성중인 내용은 삭제됩니다.
                                `;
                                document.getElementById('alert_cc_confirm').onclick = (event) => {
                                location.href = `{{ route('lecture.qnaView', ['lecture_id' => $lecture_id]) }}`;
                                sendData();
                                }
                                ">취소</button>
                        <button type="button" class="btn-normal col2 btn-primary btn-round" onclick="
                        document.getElementById('alert_cc_dim').classList.remove('dn');
                        document.getElementById('alert_cc_content').innerText = '수정하시겠습니까?';
                        document.getElementById('alert_cc_confirm').onclick = (event) => {
                            event.target.parentNode.parentNode.parentNode.parentNode.classList.add('dn');
                            sendData();
                        }
                    ">수정</button></div>
                </form>
                {{--            <button onclick="console.log(fileList)">test</button>--}}
            </div>
            {{--        <div class="a-center p-30 pt-0"><button class="btn-normal col2 btn-gray btn-line btn-round mr-20">취소</button><button class="btn-normal col2 btn-primary btn-round">등록</button></div>--}}
        </div>
    </div>
@endsection


{{--QNA EDIT<br/>--}}
{{--<form method="post" action="{{ route('lecture.qna.edit', ['lecture_id' => $lecture_id, 'qna_id' => $qna['id']]) }}" enctype="multipart/form-data">--}}
{{--    @csrf--}}
{{--    <input type="text" name="title" value="{{ old("title") ?? $qna['title']}}" placeholder="title" /><br/>--}}
{{--    <input type="text" name="content" value="{{ old("content") ?? $qna['content'] }}" placeholder="content" /><br/>--}}
{{--    <input type="file" name="file[]" multiple /><br/>--}}

{{--    @for($i = 0;$i < count($qna['file']);$i++)--}}
{{--        <div name="deletable" onclick="this.style.display='none'; this.children[0].value = '-';">--}}
{{--            <input type="hidden" name="oldFile[]" value="+" />--}}
{{--            {{ $qna['file'][$i]->fileRealName }}--}}
{{--        </div>--}}
{{--    @endfor--}}
{{--    <input type="radio" name="lock" value="1" {{ $qna['lock'] == 1 ? 'checked' :'' }} />--}}
{{--    <input type="radio" name="lock" value="0" {{ $qna['lock'] == 0 ? 'checked' :'' }} />--}}
{{--    <button type="submit">edit</button>--}}
{{--</form>--}}
