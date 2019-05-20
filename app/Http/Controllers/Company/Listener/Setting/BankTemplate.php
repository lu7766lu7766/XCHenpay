<?php
/**
 * Created by PhpStorm.
 * User: funny
 * Date: 2019/5/8
 * Time: 下午 02:39
 */

namespace App\Http\Controllers\Company\Listener\Setting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Listener\Setting\BankTemplateEditRequest;
use App\Http\Requests\Listener\Setting\BankTemplateFrontRequest;
use App\Http\Requests\Listener\Setting\BankTemplateInfoRequest;
use App\Http\Requests\Listener\Setting\BankTemplateRequest;
use App\Service\Company\Listener\Setting\BankTemplate as Service;

class BankTemplate extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function indexView()
    {
        return view('admin.cashier.listenerSetting');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function template()
    {
        return view('admin.cashier.listenerSettingTemplate');
    }

    /**
     * @param BankTemplateRequest $request
     * @return \App\Models\Template|\Illuminate\Database\Eloquent\Collection
     */
    public function index(BankTemplateRequest $request)
    {
        return Service::getInstance()->list($request);
    }

    /**
     * @param BankTemplateRequest $request
     * @return int
     */
    public function total(BankTemplateRequest $request)
    {
        return Service::getInstance()->total($request);
    }

    /**
     * @param int $id
     * @return \App\Models\Template|\Illuminate\Database\Eloquent\Model
     * @throws \Illuminate\Validation\ValidationException
     */
    public function info(int $id)
    {
        return Service::getInstance()->info(BankTemplateInfoRequest::getHandle(['id' => $id]));
    }

    /**
     * @param BankTemplateEditRequest $request
     * @return \App\Models\Template|null
     */
    public function edit(BankTemplateEditRequest $request)
    {
        return Service::getInstance()->edit($request);
    }

    /**
     * @param BankTemplateFrontRequest $request
     * @return \App\Models\Template|\Illuminate\Database\Eloquent\Collection
     */
    public function front(BankTemplateFrontRequest $request)
    {
        return Service::getInstance()->front($request);
    }

    /**
     * @return \App\Models\Bank|\Illuminate\Database\Eloquent\Collection
     */
    public function options()
    {
        return Service::getInstance()->options();
    }
}
