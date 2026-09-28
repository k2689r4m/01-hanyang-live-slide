@extends('backup.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- 3단길이의 사이드 바 -->
        @include('backup.classes.sidebar')

        <!-- 9단길이의 첫번째 열 -->
            <div class="col-md-10">
                <div class="card">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" id="myTab" role="tablist" style="display: none;">
                        <li class="nav-item">
                            <a class="nav-link active" id="progress-tab" data-toggle="tab" href="#progress" role="tab" aria-controls="progress" aria-selected="true">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="notice-tab" data-toggle="tab" href="#notice" role="tab" aria-controls="notice" aria-selected="false">Profile</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="file-tab" data-toggle="tab" href="#file" role="tab" aria-controls="file" aria-selected="false">Messages</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="ask-tab" data-toggle="tab" href="#ask" role="tab" aria-controls="ask" aria-selected="false">Settings</a>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="tab-pane active" id="progress" role="tabpanel" aria-labelledby="progress-tab">
                            @include('backup.classes.classes_progress')
                        </div>
                        <div class="tab-pane" id="notice" role="tabpanel" aria-labelledby="notice-tab">
                            @include('backup.classes.classes_notice')
                        </div>
                        <div class="tab-pane" id="file" role="tabpanel" aria-labelledby="file-tab">
                            @include('backup.classes.classes_file')
                        </div>
                        <div class="tab-pane" id="ask" role="tabpanel" aria-labelledby="ask-tab">
                            질문답변 입니다 ㅎㅎ ^^
                        </div>
                    </div>

                </div>
            </div>
        </div>

        @include('backup.classes.delete_modal')
        {{--    @include('classes.delete_modal')--}}
        @endsection


        @section('script')
            <script type="text/javascript">
                let _index_id;
                let _lecture_id;

                function modal_up(lecture_id, index_id){
                    _index_id = index_id;
                    _lecture_id = lecture_id;
                }

                function reply_click()
                {
                    window.location=`delete/${_lecture_id}/${_index_id}`;
                }

                const handleChangeHighlight = (id) => {
                    const list = ['_progress', '_notice', '_file', '_ask'];

                    list.forEach(item => {
                       if (item !== id) {
                           document.getElementById(item).classList.remove('active');
                       }
                       else {
                           const target = document.getElementById(item);
                           if (!target.classList.contains('active')) {
                                target.classList.add('active');
                           }
                       }
                    });
                }

                @section('onloadMain')
                document.getElementById('_progress').addEventListener('click', () => {
                    document.getElementById('progress-tab').click();
                    handleChangeHighlight('_progress');
                });
                document.getElementById('_notice').addEventListener('click', () => {
                    document.getElementById('notice-tab').click();
                    handleChangeHighlight('_notice');
                });
                document.getElementById('_file').addEventListener('click', () => {
                    document.getElementById('file-tab').click();
                    handleChangeHighlight('_file');
                });
                document.getElementById('_ask').addEventListener('click', () => {
                    document.getElementById('ask-tab').click();
                    handleChangeHighlight('_ask');
                });

                //공지사항 등록
                const noticeClear = document.getElementById('notice-clear');
                const noticeTitle = document.getElementById('notice-title');
                const noticeContent = document.getElementById('notice-content');
                const noticeFileList = document.getElementsByName('file[]');

                const noticeFileAdd = document.getElementById('notice-file-add');
                const noticeFileDelete = document.getElementById('notice-file-delete');

                const noticeFiles = document.getElementById('notice-files');

                const handleClear = () => {
                    noticeTitle.value = '';
                    noticeContent.value = '';
                    while(noticeFiles.children.length > 1)
                    {
                        noticeFiles.lastChild.remove();
                        noticeFiles.firstChild.getElementsByTagName('input')[0].value = '';
                        noticeFiles.firstChild.classList.add('mb-3');
                    }
                }

                const handleDelete = (e) => {
                    if (noticeFiles.children.length === 1) {
                        const ps = e.target.parentNode.previousSibling;

                        if (ps.nodeType === 1) {
                            ps.firstChild.value = '';
                        }
                        else {
                            ps.previousSibling.firstChild.value = '';
                        }
                    }
                    else if (noticeFiles.children.length === 2) {
                        e.target.parentNode.parentNode.parentNode.firstChild.classList.add('mb-3');
                        e.target.parentNode.parentNode.remove();
                    }
                    else {
                        e.target.parentNode.parentNode.remove();
                    }
                }

                const handleAdd = (e) => {
                    e.target.parentNode.parentNode.parentNode.lastChild.classList.remove('mb-3');
                    const div = document.createElement('div');
                    div.classList.add('input-group');
                    div.classList.add('mb-3');
                    const titleDiv = document.createElement('div');
                    titleDiv.classList.add('input-group-prepend');
                    const titleSpan = document.createElement('span');
                    titleSpan.classList.add('input-group-text');
                    titleSpan.innerHTML = '* 첨부파일';
                    titleDiv.appendChild(titleSpan);
                    const fileDiv = document.createElement('div');
                    fileDiv.classList.add('custom-file');
                    const fileInput = document.createElement('input');
                    fileInput.type = 'file';
                    fileInput.classList.add('custom-file-input');
                    fileInput.name = 'file[]';
                    const lastInputId = noticeFiles.lastChild.getElementsByTagName('input')[0].id;
                    fileInput.id = lastInputId.substring(0, lastInputId.length - 2) + (lastInputId[lastInputId.length - 1] * 1 + 1);
                    const fileLabel = document.createElement('label');
                    fileLabel.classList.add('custom-file-label');
                    fileLabel.setAttribute('for', lastInputId.substring(0, lastInputId.length - 2) + (lastInputId[lastInputId.length - 1] * 1 + 1));
                    fileLabel.innerHTML = 'Choose file';
                    fileDiv.appendChild(fileInput);
                    fileDiv.appendChild(fileLabel);
                    const buttonDiv = document.createElement('div');
                    buttonDiv.classList.add('input-group-append');
                    const buttonAdd = document.createElement('button');
                    buttonAdd.classList.add('btn');
                    buttonAdd.classList.add('btn-outline-secondary');
                    buttonAdd.type = 'button';
                    buttonAdd.name = 'notice-file-add';
                    buttonAdd.innerHTML = '+';
                    buttonAdd.addEventListener('click', handleAdd);
                    const buttonDelete = document.createElement('button');
                    buttonDelete.classList.add('btn');
                    buttonDelete.classList.add('btn-outline-secondary');
                    buttonDelete.type = 'button';
                    buttonDelete.name = 'notice-file-delete';
                    buttonDelete.innerHTML = '-';
                    buttonDelete.addEventListener('click', handleDelete);
                    buttonDiv.appendChild(buttonAdd);
                    buttonDiv.appendChild(buttonDelete);

                    div.appendChild(titleDiv);
                    div.appendChild(fileDiv);
                    div.appendChild(buttonDiv);

                    noticeFiles.appendChild(div);
                }

                noticeClear.addEventListener('click', () => {
                    handleClear();
                })

                noticeFileAdd.addEventListener('click', (e) => {
                    handleAdd(e);
                });

                noticeFileDelete.addEventListener('click', (e) => {
                    handleDelete(e);
                })
                @endsection
            </script>
@endsection
