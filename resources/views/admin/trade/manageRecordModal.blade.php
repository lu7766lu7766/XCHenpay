<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title" id="lend_manage_title">管理下发</h4>
</div>
<div class="modal-body">
    <label for="Select" style="margin-right:10px;float:left;">下发帐号</label>

    <form id="myForm">
        <label class="radio-inline">
            <input type="radio" name="radios"  value="1" @if($lendRecord->lend_state == 1) checked @endif>完成下发
        </label>

        <label class="radio-inline">
            <input type="radio" name="radios"  value="0" @if($lendRecord->lend_state == 2) checked @endif>拒绝下发
        </label>
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
    <button type="button" class="btn btn-primary" id="manage_btn" name="apply_btn" data-dismiss="modal">管理</button>
</div>

<script>
    $('#manage_btn').on('click', function (e) {
        var data = {
            id: "{{ $lendRecord->id }}",
            operation: $('input[name=radios]:checked', '#myForm').val()
        };

        $.ajax({
            url: "{{ route('admin.lendManage.Manage') }}",
            type: "post",
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
            },
            success: function (data) {
                complete(data);

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