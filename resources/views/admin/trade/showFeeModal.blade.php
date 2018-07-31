<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title" id="lend_info_title">通道资讯: {{$payment->name}}</h4>
</div>
<div class="modal-body">

    <!-- Money input-->
    <div class="panel-body border">
        <form  enctype="multipart/form-data" class="form-horizontal form-bordered">
            <div class="form-group striped-col">
                <label class="col-md-3 control-label">API编号</label>
                <div class="col-md-9">
                    <p class="form-control-static">{{ $payment->ipay6_id }}</p>
                </div>
            </div>

            <div class="form-group striped-col">
                <label class="col-md-3 control-label">通道名称</label>
                <div class="col-md-9">
                    <p class="form-control-static">{{ $payment->name }}</p>
                </div>
            </div>

            <div class="form-group striped-col">
                <label class="col-md-3 control-label">手续费率</label>
                <div class="col-md-9">
                    <p class="form-control-static">{{ $payment->fee }}%</p>
                </div>
            </div>

            <div class="form-group striped-col">
                <label class="col-md-3 control-label">描述</label>
                <div class="col-md-9">
                    <p class="form-control-static">{{ $payment->description }}</p>
                </div>
            </div>



        </form>
    </div>

</div>
<div class="modal-footer">
    <button type="button" class="btn btn-primary" data-dismiss="modal">确定</button>
</div>