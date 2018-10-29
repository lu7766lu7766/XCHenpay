<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title">交易状态修改</h4>
</div>
<div class="modal-body">
    <form>
        <div class="form-group row" style="padding: 12px 15px 0 15px;">
            <label class="col-sm-3 col-form-label">系統交易号</label>
            <div class="col-sm-9">{{ $authcode->trade_seq }}</div>
        </div>
        <div class="form-group row" style="padding: 3px 15px">
            <label class="col-sm-3 col-form-label">商户交易号</label>
            <div class="col-sm-9">{{ $authcode->trade_service_id }}</div>
        </div>
        <div class="form-group row" style="padding: 3px 15px">
            <label class="col-sm-3 col-form-label">金额</label>
            <div class="col-sm-9">{{ $authcode->amount }}</div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3 col-form-label">
                <h5 style="font-weight: 700;">交易状态</h5>
            </label>
            <div class="col-sm-9">
                <select class="form-control" name="pay_state">
                    @foreach($stateList as $stKey => $stVal)
                        <option value="{{ $stKey }}"
                                @if($stKey == $authcode->pay_state) selected @endif>{{ $stVal }}</option>
                    @endforeach
                </select>
            </div>
        </div>

    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>
    <button type="button" class="btn btn-primary" id="state-submit" data-id="{{ $authcode->id }}">更新</button>
</div>

<script>
    $('#state-submit').click(function () {
        let id = $(this).data('id');
        $.ajax({
            url: '{{ route('admin.authcode.stateUpdate') }}',
            type: 'post',
            data: {
                id: id,
                state: $('select[name="pay_state"]').val()
            },
            dataType: 'json',
            success: function () {
                vm.$root.$emit('reload')
                // table.ajax.reload();
                $('#stateEditModal').modal('toggle');
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr + ' ' + thrownError);
                alert('与服务器沟通错误');
            }
        });
    });
</script>
