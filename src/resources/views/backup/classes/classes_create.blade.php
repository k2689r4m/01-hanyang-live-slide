<div class="row">
<!-- 9단길이의 첫번째 열 -->
    <div class="col-md-12">
            <form method="POST" action="{{ route('classes.submit') }}">
                @csrf
                    <div class="row">
                        <input type="hidden" name="lecture_id" value="{{ $lecture_id }}"/>
                        <div class="col-md-3">수업명</div>
                        <div class="col-md-9"><input name="name" /></div>

                        <div class="col-md-3">수업명 URL</div>
                        <div class="col-md-9"><input /></div>


                        <div class="col-md-3">
                            수업입장 기간을 선택하세요
                        </div>
                        <div class="col-md-9">
                            <input type="radio" name="active_always" value="0" checked/> 항상 활성화
                            <input type="radio" name="active_always" value="1"/> 제한
                            <input type="radio" name="active_always" value="2"/> 비활성화
                        </div>



                        <div class="col-md-3">수업 입장기간</div>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-sm-4"><p><input name="active_start_date" style="height: 29px;" type="date"></p></div>
                                <div class="col-sm-4 row"><input name="active_start_hour" style="height: 29px;" class="col-sm" type="number"/><p class="col-sm">hour</p></div>
                                <div class="col-sm-4 row"><input name="active_start_min" style="height: 29px;" class="col-sm" type="number"/><p class="col-sm">minutes</p></div>

                                <div class="col-sm-4"><p><input name="active_end_date" style="height: 29px;" type="date"></p></div>
                                <div class="col-sm-4 row"><input name="active_end_hour" style="height: 29px;" class="col-sm" type="number"/><p class="col-sm">hour</p></div>
                                <div class="col-sm-4 row"><input name="active_end_min" style="height: 29px;" class="col-sm" type="number"/><p class="col-sm">minutes</p></div>
                            </div>

                        </div>

                        <div class="col-md-3">
                            수업 다시보기 기간을 선택하세요
                        </div>
                        <div class="col-md-9">
                            <input type="radio" name="record_always" value="0" checked/> 항상 활성화
                            <input type="radio" name="record_always" value="1"/> 제한
                            <input type="radio" name="record_always" value="2"/> 비활성화
                        </div>

                        <div class="col-md-3">다시보기 입장기간</div>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-sm-4"><p><input name="record_start_date" style="height: 29px;" type="date"></p></div>
                                <div class="col-sm-4 row"><input name="record_start_hour" style="height: 29px;" class="col-sm" type="number"/><p class="col-sm">hour</p></div>
                                <div class="col-sm-4 row"><input name="record_start_min" style="height: 29px;" class="col-sm" type="number"/><p class="col-sm">minutes</p></div>

                                <div class="col-sm-4"><p><input name="record_end_date" style="height: 29px;" type="date"></p></div>
                                <div class="col-sm-4 row"><input name="record_end_hour" style="height: 29px;" class="col-sm" type="number"/><p class="col-sm">hour</p></div>
                                <div class="col-sm-4 row"><input name="record_end_min" style="height: 29px;" class="col-sm" type="number"/><p class="col-sm">minutes</p></div>
                            </div>
                        </div>

                        <div style="width: 100%;display: flex;justify-content: flex-end;">
                            <button style="margin-right: 20px;" onclick="history.back()" type="button">취소</button>
                            <button type="submit">시작하기</button>
                        </div>

                    </div>
            </form>
    </div>
</div>
