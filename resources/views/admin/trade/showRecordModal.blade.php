<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title" id="lend_info_title">下发资讯: {{$lendRecord->record_seq}}</h4>
</div>
<div class="modal-body">
    <table class="table table-bordered table-striped" id="users">

        <tr>
            <td>下发状态</td>
            <td>
                {{ $lendRecord->lend_summary }}
            </td>
        </tr>

        <tr>
            <td>单号</td>
            <td>
                {{ $lendRecord->record_seq }}
            </td>
        </tr>

        <tr>
            <td>户名</td>
            <td>
                {{ $account->name }}
            </td>
        </tr>

        <tr>
            <td>银行卡号</td>
            <td>
                {{ $account->account }}
            </td>
        </tr>

        <tr>
            <td>银行名</td>
            <td>
                {{ $account->bank_name }}
            </td>
        </tr>

        <tr>
            <td>开户支行</td>
            <td>
                {{ $account->bank_branch }}
            </td>
        </tr>

        <tr>
            <td>申请金额</td>
            <td>
                {{ $lendRecord->amount }}
            </td>
        </tr>

        <tr>
            <td>下发手续费</td>
            <td>
                {{ $lendRecord->fee }}
            </td>
        </tr>

        <tr>
            <td>下发金额</td>
            <td>
                {{ $lendRecord->amount - $lendRecord->fee }}
            </td>
        </tr>

        <tr>
            <td>申请时间</td>
            <td>
                {{ $lendRecord->created_at }}
            </td>
        </tr>

    </table>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-primary" data-dismiss="modal">确定</button>
</div>