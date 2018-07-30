<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title" id="lend_info_title">下发资讯: {{$lendRecord->record_seq}}</h4>
</div>
<div class="modal-body">

    <!-- Money input-->
    <div class="panel-body border">
        <form  enctype="multipart/form-data" class="form-horizontal form-bordered">
            <div class="form-group striped-col">
                <label class="col-md-3 control-label">下发状态</label>
                <div class="col-md-9">
                    <p class="form-control-static">{{ $lendRecord->lend_summary }}</p>
                </div>
            </div>

            <div class="form-group striped-col">
                <label class="col-md-3 control-label">单号</label>
                <div class="col-md-9">
                    <p class="form-control-static">{{ $lendRecord->record_seq }}</p>
                </div>
            </div>

            <div class="form-group striped-col">
                <label class="col-md-3 control-label">户名</label>
                <div class="col-md-9">
                    <p class="form-control-static">{{ $account->name }}</p>
                </div>
            </div>

            <div class="form-group striped-col">
                <label class="col-md-3 control-label">银行卡号</label>
                <div class="col-md-9">
                    <p class="form-control-static">{{ $account->account }}</p>
                </div>
            </div>

            <div class="form-group striped-col">
                <label class="col-md-3 control-label">银行名</label>
                <div class="col-md-9">
                    <p class="form-control-static">{{ $account->bank_name }}</p>
                </div>
            </div>

            <div class="form-group striped-col">
                <label class="col-md-3 control-label">开户支行</label>
                <div class="col-md-9">
                    <p class="form-control-static">{{ $account->bank_branch }}</p>
                </div>
            </div>

            <div class="form-group striped-col">
                <label class="col-md-3 control-label">申请金额</label>
                <div class="col-md-9">
                    <p class="form-control-static">{{ $lendRecord->amount }}</p>
                </div>
            </div>

            <div class="form-group striped-col">
                <label class="col-md-3 control-label">下发手续费</label>
                <div class="col-md-9">
                    <p class="form-control-static">{{ $lendRecord->fee }}</p>
                </div>
            </div>

            <div class="form-group striped-col">
                <label class="col-md-3 control-label">下发金额</label>
                <div class="col-md-9">
                    <p class="form-control-static">{{ $lendRecord->amount - $lendRecord->fee }}</p>
                </div>
            </div>

            <div class="form-group striped-col">
                <label class="col-md-3 control-label">备注</label>
                <div class="col-md-9">
                    <p class="form-control-static">{{ $lendRecord->description }}</p>
                </div>
            </div>

            <div class="form-group striped-col">
                <label class="col-md-3 control-label">申请时间</label>
                <div class="col-md-9">
                    <p class="form-control-static">{{ $lendRecord->created_at }}</p>
                </div>
            </div>

        </form>
    </div>

</div>
<div class="modal-footer">
    <button type="button" class="btn btn-primary" data-dismiss="modal">确定</button>
</div>