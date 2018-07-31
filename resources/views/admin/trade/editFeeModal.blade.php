<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title" id="lend_info_title">通道资讯: {{$payment->name}}</h4>
</div>
<div class="modal-body">

    <!-- Money input-->
    <div class="panel-body border">
        <form  enctype="multipart/form-data" class="form-horizontal form-bordered" id="myForm">
            <div class="form-group striped-col">
                <label class="col-md-3 control-label">API编号</label>
                <div class="col-md-9">
                    <p class="form-control-static">{{ $payment->i6pay_id }}</p>
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
                <div class="col-sm-9">
                    <input id="fee" name="password_confirm" type="text"
                           placeholder="请输入手续费率" class="form-control"
                           value="{!! old('fee', $payment->fee) !!}"/>
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
    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
    <button type="button" class="btn btn-primary" id="edit_btn" data-dismiss="modal">修改</button>
</div>

<script>
    $('#edit_btn').on('click', function (e) {
       var data = {
            id: '{{ $payment->id }}',
            fee: $('#fee').val()
        };

        console.log(data);

        $.ajax({
            url: "{{ route('admin.authcode.updateFeeInfo') }}",
            type: "post",
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
            },
            success: function (data) {
                //complete(data);
                alert('成功');
                fee_table.ajax.reload();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert('错误，与服务器沟通失败');
            }
        });

        var complete = function (data) {
            if (data.Result != 'OK') {
                alert(data.Message);
                return;
            }

            table.ajax.reload();
            alert('管理成功');
            return;
        };
    });
</script>