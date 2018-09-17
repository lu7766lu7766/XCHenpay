<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title" id="lend_info_title">@lang('Trade/LogQuery/form.showModalTitle'): {{$authcode->trade_seq}}</h4>
</div>
<div class="modal-body">

    <!-- Money input-->
    <div class="panel-body border">
        <form  enctype="multipart/form-data" class="form-horizontal form-bordered">
            <div class="form-group striped-col">
                <label class="col-md-3 control-label">@lang('Trade/LogQuery/form.pay_summary')</label>
                <div class="col-md-9">
                    <p class="form-control-static">{{ $authcode->pay_summary }}</p>
                </div>
            </div>

            <div class="form-group striped-col">
                <label class="col-md-3 control-label">@lang('Trade/LogQuery/form.trade_seq')</label>
                <div class="col-md-9">
                    <p class="form-control-static">{{ $authcode->trade_seq }}</p>
                </div>
            </div>

            <div class="form-group striped-col">
                <label class="col-md-3 control-label">@lang('Trade/LogQuery/form.trade_service_id')</label>
                <div class="col-md-9">
                    <p class="form-control-static">{{ $authcode->trade_service_id }}</p>
                </div>
            </div>

            <div class="form-group striped-col">
                <label class="col-md-3 control-label">@lang('Trade/LogQuery/form.trade_type_name')</label>
                <div class="col-md-9">
                    <p class="form-control-static">{{ $authcode->tradeType->name }}</p>
                </div>
            </div>

            <div class="form-group striped-col">
                <label class="col-md-3 control-label">@lang('Trade/LogQuery/form.customer_id')</label>
                <div class="col-md-9">
                    <p class="form-control-static">{{ $authcode->customer_id }}</p>
                </div>
            </div>

            <div class="form-group striped-col">
                <label class="col-md-3 control-label">@lang('Trade/LogQuery/form.item_name')</label>
                <div class="col-md-9">
                    <p class="form-control-static">{{ $authcode->item_name }}</p>
                </div>
            </div>

            <div class="form-group striped-col">
                <label class="col-md-3 control-label">@lang('Trade/LogQuery/form.amount')</label>
                <div class="col-md-9">
                    <p class="form-control-static">{{ $authcode->amount }}</p>
                </div>
            </div>

            <div class="form-group striped-col">
                <label class="col-md-3 control-label">@lang('Trade/LogQuery/form.fee')</label>
                <div class="col-md-9">
                    <p class="form-control-static">{{ $authcode->fee }}</p>
                </div>
            </div>

            <div class="form-group striped-col">
                <label class="col-md-3 control-label">@lang('Trade/LogQuery/form.currency')</label>
                <div class="col-md-9">
                    <p class="form-control-static">{{ $authcode->currency->name }}</p>
                </div>
            </div>

            <div class="form-group striped-col">
                <label class="col-md-3 control-label">@lang('Trade/LogQuery/form.notify_url')</label>
                <div class="col-md-9">
                    <p class="form-control-static">{{ $authcode->notify_url }}</p>
                </div>
            </div>

            <div class="form-group striped-col">
                <label class="col-md-3 control-label">@lang('Trade/LogQuery/form.apply_time')</label>
                <div class="col-md-9">
                    <p class="form-control-static">{{ $authcode->created_at }}</p>
                </div>
            </div>

            <div class="form-group striped-col">
                <label class="col-md-3 control-label">@lang('Trade/LogQuery/form.pay_start_time')</label>
                <div class="col-md-9">
                    <p class="form-control-static">{{ $authcode->pay_start_time }}</p>
                </div>
            </div>

            <div class="form-group striped-col">
                <label class="col-md-3 control-label">@lang('Trade/LogQuery/form.pay_end_time')</label>
                <div class="col-md-9">
                    <p class="form-control-static">{{ $authcode->pay_end_time }}</p>
                </div>
            </div>

        </form>
    </div>

</div>
<div class="modal-footer">
    <button type="button" class="btn btn-primary" data-dismiss="modal">确定</button>
</div>