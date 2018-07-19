<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title" id="user_delete_confirm_title">请填写下发资料</h4>
</div>
<div class="modal-body">
    <label for="Select" style="margin-right:10px;float:left;">下发帐号</label>

    <select id="account-selections" class="form-control" style="width:200px;">
        <option >请选择</option>

        @foreach($accounts as $account)
            <option value='{{$account}}'> {{$account}} </option>
        @endforeach

    </select>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
    <button type="button" class="btn btn-primary" id="apply_btn" name="apply_btn" data-dismiss="modal">申请</button>
</div>

<script>
    $('#apply_btn').on('click', function (e) {
        var data = {
            id: "{{ $authcode->id }}",
            account: $("#account-selections :selected").val()
        };

        console.log(data);

        $.ajax({
            url: "{{ route('admin.lendApply.apply') }}",
            type: "post",
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
            },
            success: function (data) {
                completeDelete(data);
                table.ajax.reload();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert('错误，与服务器沟通失败');
            }
        });

        var completeDelete = function (data) {
            if (data.Result != 'OK') {
                alert(data.Message);
                return;
            }

            alert('successful');
            return;
        };
    });
</script>