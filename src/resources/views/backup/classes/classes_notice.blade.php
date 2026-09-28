<div class="card-header">
    <div class="row">
        <ul class="nav nav-tabs col-sm-6" id="myTab-notice" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="notice-1-tab" data-toggle="tab" href="#notice-1" role="tab" aria-controls="notice-1" aria-selected="false">공지사항</a>
            </li>
            @if ($owned)
                <li class="nav-item">
                    <a class="nav-link" id="create-notice-tab" data-toggle="tab" href="#create-notice" role="tab" aria-controls="create-notice" aria-selected="false">개설하기</a>
                </li>
            @endif
        </ul>
    </div>
</div>

<div class="card-body">
    <div class="tab-content" id="myTab-noticeContent">
        <div class="tab-pane fade show active" id="notice-1" role="tabpanel" aria-labelledby="notice-1-tab">
            <div class="card-body">
                <table class="table">
                    <thead class="thead-light">
                    <tr>
                        <th scope="col">번호</th>
                        <th scope="col">제목</th>
                        <th scope="col">작성일</th>
                        <th scope="col">삭제</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        @if ($owned)
            <div class="tab-pane fade" id="create-notice" role="tabpanel" aria-labelledby="create-notice-tab">
                @include('backup.classes.classes_notice_create')
            </div>
        @endif
    </div>
</div>
