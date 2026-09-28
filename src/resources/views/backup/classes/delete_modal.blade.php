{{--        모달 가운데 적용 필요--}}
{{--        <style>--}}
{{--            .modal {--}}
{{--                text-align: center;--}}
{{--            }--}}
{{--            @media screen and (min-width: 768px) {--}}
{{--                .modal:before {--}}
{{--                    display: inline-block;--}}
{{--                    vertical-align: middle;--}}
{{--                    content: " ";--}}
{{--                    height: 100%;--}}
{{--                }--}}
{{--            }--}}
{{--            .modal-dialog {--}}
{{--                display: inline-block;--}}
{{--                text-align: left;--}}
{{--                vertical-align: middle;--}}
{{--            }--}}
{{--        </style>--}}

<!-- Modal -->
<div class="modal fade" id="myModalHorizontal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <!-- Modal Header -->
        {{--                    <div class="modal-header" style="background: #ff0000">--}}
        {{--                    </div>            --}}
        <!-- Modal Body -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12" style="padding-bottom: 10px">
                        정말로 삭제하시겠습니까?
                    </div>
                    <div class="col-sm-12 text-right">
                        <button type="button" class="btn btn-secondary" onClick="reply_click()">삭제</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">취소</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




