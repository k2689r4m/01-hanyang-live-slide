@extends('backup.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- 3단길이의 사이드 바 -->
        @include('backup.classes.sidebar')

        <!-- 9단길이의 첫번째 열 -->
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-6" style="display: flex;align-items: center;">수업 목록</div>
                            <div class="col-sm-6 text-right">
{{--                                <button onclick="window.location=''" type="button" class="btn btn-secondary pull-right">개설하기</button>--}}
                            </div>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('classes.editSubmit', $classes['id']) }}">
                        @csrf

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">수업명</div>
                                <div class="col-md-9"><input name="name" value="{{ $classes['name'] }}"/></div>

                                <div class="col-md-3">수업명 URL</div>
                                <div class="col-md-9"><input value="URL"/></div>


                                <div class="col-md-3">
                                    수업입장 기간을 선택하세요
                                </div>
                                <div class="col-md-9">
                                    <input type="radio" name="active_always" value="0" {{$classes['active_always'] == 0 ? 'checked' : 0}}/> 항상 활성화
                                    <input type="radio" name="active_always" value="1" {{$classes['active_always'] == 1 ? 'checked' : 0}}/> 제한
                                    <input type="radio" name="active_always" value="2" {{$classes['active_always'] == 2 ? 'checked' : 0}}/> 비활성화
                                </div>



                                <div class="col-md-3">수업 입장기간</div>
                                <div class="col-md-9">
                                    <div class="row">
                                        <div class="col-sm-4"><p><input name="active_start_date" style="height: 29px;" type="date" value="{{ $_date['a_s_date'] }}"></p></div>
                                        <div class="col-sm-4 row"><input name="active_start_hour" style="height: 29px;" class="col-sm" type="number" value="{{ $_date['a_s_h'] }}"/><p class="col-sm">hour</p></div>
                                        <div class="col-sm-4 row"><input name="active_start_min" style="height: 29px;" class="col-sm" type="number" value="{{ $_date['a_s_m'] }}"/><p class="col-sm">minutes</p></div>

                                        <div class="col-sm-4"><p><input name="active_end_date" style="height: 29px;" type="date" value="{{ $_date['a_e_date'] }}"></p></div>
                                        <div class="col-sm-4 row"><input name="active_end_hour" style="height: 29px;" class="col-sm" type="number" value="{{ $_date['a_e_h'] }}"/><p class="col-sm">hour</p></div>
                                        <div class="col-sm-4 row"><input name="active_end_min" style="height: 29px;" class="col-sm" type="number" value="{{ $_date['a_e_m'] }}"/><p class="col-sm">minutes</p></div>
                                    </div>

                                </div>

                                <div class="col-md-3">
                                    수업 다시보기 기간을 선택하세요
                                </div>
                                <div class="col-md-9">
                                    <input type="radio" name="record_always" value="0" {{$classes['record_always'] == 0 ? 'checked' : 0}} /> 항상 활성화
                                    <input type="radio" name="record_always" value="1" {{$classes['record_always'] == 1 ? 'checked' : 0}}/> 제한
                                    <input type="radio" name="record_always" value="2" {{$classes['record_always'] == 2 ? 'checked' : 0}}/> 비활성화
                                </div>

                                <div class="col-md-3">다시보기 입장기간</div>
                                <div class="col-md-9">
                                    <div class="row">
                                        <div class="col-sm-4"><p><input name="record_start_date" style="height: 29px;" type="date" value="{{ $_date['r_s_date'] }}"></p></div>
                                        <div class="col-sm-4 row"><input name="record_start_hour" style="height: 29px;" class="col-sm" type="number" value="{{ $_date['r_s_h'] }}"/><p class="col-sm">hour</p></div>
                                        <div class="col-sm-4 row"><input name="record_start_min" style="height: 29px;" class="col-sm" type="number" value="{{ $_date['r_s_h'] }}"/><p class="col-sm">minutes</p></div>

                                        <div class="col-sm-4"><p><input name="record_end_date" style="height: 29px;" type="date" value="{{ $_date['r_e_date'] }}"></p></div>
                                        <div class="col-sm-4 row"><input name="record_end_hour" style="height: 29px;" class="col-sm" type="number" value="{{ $_date['r_e_h'] }}"/><p class="col-sm">hour</p></div>
                                        <div class="col-sm-4 row"><input name="record_end_min" style="height: 29px;" class="col-sm" type="number" value="{{ $_date['r_e_m'] }}"/><p class="col-sm">minutes</p></div>
                                    </div>
                                </div>

                                <div>
                                    <button>x</button>
                                    <button type="submit">o</button>
                                </div>

                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

