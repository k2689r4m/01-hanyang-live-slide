<div class="card-header">
    <div class="row">
        <ul class="nav nav-tabs col-sm-6" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link" id="inform-tab" data-toggle="tab" href="#inform" role="tab" aria-controls="inform" aria-selected="false">기본정보</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" id="classes-tab" data-toggle="tab" href="#classes" role="tab" aria-controls="classes" aria-selected="true">수업</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="avg-tab" data-toggle="tab" href="#avg" role="tab" aria-controls="avg" aria-selected="false">통계</a>
            </li>
            @if ($owned)
                <li class="nav-item">
                    <a class="nav-link" id="create-tab" data-toggle="tab" href="#create" role="tab" aria-controls="create" aria-selected="false">개설하기</a>
                </li>
            @endif
        </ul>
    </div>
</div>

<div class="card-body">
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade" id="inform" role="tabpanel" aria-labelledby="inform-tab">
            @include('backup.classes.classes_inform')
        </div>
        <div class="tab-pane fade show active" id="classes" role="tabpanel" aria-labelledby="classes-tab">
            @include('backup.classes.classes_list')
        </div>
        <div class="tab-pane fade" id="avg" role="tabpanel" aria-labelledby="avg-tab">
            @include('backup.classes.classes_statistics')
        </div>
        @if ($owned)
            <div class="tab-pane fade" id="create" role="tabpanel" aria-labelledby="create-tab">
                @include('backup.classes.classes_create')
            </div>
        @endif
    </div>
</div>
