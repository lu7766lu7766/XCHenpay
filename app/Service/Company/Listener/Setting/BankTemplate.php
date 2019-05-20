<?php
/**
 * Created by PhpStorm.
 * User: funny
 * Date: 2019/5/8
 * Time: 下午 03:28
 */

namespace App\Service\Company\Listener\Setting;

use App\Http\Requests\Listener\Setting\BankTemplateEditRequest;
use App\Http\Requests\Listener\Setting\BankTemplateFrontRequest;
use App\Http\Requests\Listener\Setting\BankTemplateInfoRequest;
use App\Http\Requests\Listener\Setting\BankTemplateRequest;
use App\Models\Bank;
use App\Repositories\Company\Listener\Setting\Bank as BankRepo;
use App\Repositories\Company\Listener\Setting\BankTemplate as Repo;
use App\Traits\Singleton;

class BankTemplate
{
    use Singleton;

    /**
     * @param BankTemplateRequest $request
     * @return \App\Models\Template|\Illuminate\Database\Eloquent\Collection
     */
    public function list(BankTemplateRequest $request)
    {
        return app(Repo::class)->list(
            $request->getBankId(),
            $request->getStatus(),
            $request->getPage(),
            $request->getPerpage()
        );
    }

    /**
     * @param BankTemplateRequest $request
     * @return int
     */
    public function total(BankTemplateRequest $request)
    {
        return app(Repo::class)->total($request->getBankId(), $request->getStatus());
    }

    /**
     * @param BankTemplateInfoRequest $request
     * @return \App\Models\Template|\Illuminate\Database\Eloquent\Model
     */
    public function info(BankTemplateInfoRequest $request)
    {
        return app(Repo::class)->info($request->getId());
    }

    /**
     * @param BankTemplateEditRequest $request
     * @return \App\Models\Template|null
     */
    public function edit(BankTemplateEditRequest $request)
    {
        return app(Repo::class)->edit(
            $request->getBankId(),
            $request->getContents(),
            $request->getStatus(),
            $request->getId()
        );
    }

    /**
     * @param BankTemplateFrontRequest $request
     * @return \App\Models\Template|\Illuminate\Database\Eloquent\Collection
     */
    public function front(BankTemplateFrontRequest $request)
    {
        return app(Repo::class)->front(
            $request->getBankId(),
            $request->getRefresh()
        );
    }

    /**
     * @return Bank|\Illuminate\Database\Eloquent\Collection
     */
    public function options()
    {
        return app(BankRepo::class)->all();
    }
}
