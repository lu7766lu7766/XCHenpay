<?php
/**
 * Created by PhpStorm.
 * User: funny
 * Date: 2019/5/9
 * Time: 下午 02:20
 */

namespace App\Repositories\Company\Listener\Setting;

use App\Constants\Common\StatusConstants;
use App\Models\Bank;
use App\Models\Template;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\Relation;

class BankTemplate
{
    /**
     * @param int|null $bankId
     * @param string|null $status
     * @param int $page
     * @param int $perpage
     * @return Collection|Template
     */
    public function list(
        int $bankId = null,
        string $status = null,
        int $page = 1,
        int $perpage = 20
    ) {
        try {
            $query = Template::query()
                ->with('bank')
                ->whereHas('bank', function (Builder $builder) use ($bankId) {
                    if (!is_null($bankId)) {
                        $builder->where('bank.id', $bankId);
                    }
                });
            if (!is_null($status)) {
                $query->where('status', $status);
            }
            $result = $query->forPage($page, $perpage)->orderBy('id', 'DESC')->get();
        } catch (\Throwable $e) {
            $result = collect();
            logger($e->getMessage());
        }

        return $result;
    }

    /**
     * @param int|null $bankId
     * @param string|null $status
     * @return int
     */
    public function total(int $bankId = null, string $status = null)
    {
        try {
            $query = Template::query()
                ->whereHas('bank', function (Builder $builder) use ($bankId) {
                    if (!is_null($bankId)) {
                        $builder->where('bank.id', $bankId);
                    }
                });
            if (!is_null($status)) {
                $query->where('status', $status);
            }
            $result = $query->count();
        } catch (\Throwable $e) {
            $result = 0;
            logger($e->getMessage());
        }

        return $result;
    }

    /**
     * @param int $id
     * @return Template|\Illuminate\Database\Eloquent\Model
     */
    public function info(int $id)
    {
        try {
            $result = $query = Template::query()
                ->with('bank')
                ->find($id);
        } catch (\Throwable $e) {
            $result = null;
            logger($e->getMessage());
        }

        return $result;
    }

    /**
     * @param int $bankId
     * @param string $contents
     * @param string $status
     * @param int|null $id
     * @return Template|null
     */
    public function edit(int $bankId, string $contents, string $status, int $id = null)
    {
        $result = null;
        try {
            \DB::transaction(function () use ($bankId, $contents, $status, $id, &$result) {
                /** @var Bank $bank */
                $bank = Bank::query()->find($bankId);
                if (!is_null($bank)) {
                    $template = null;
                    if (!is_null($id)) {
                        /** @var Template $template */
                        $template = Template::query()->find($id);
                    } else {
                        $template = new Template();
                    }
                    if (!is_null($template)) {
                        $template->fill(['contents' => $contents, 'status' => $status])->save();
                        $template->bank()->detach();
                        $bank->template()->attach($template);
                        $result = $template->setRelation('bank', $bank);
                    }
                }
            });
        } catch (\Throwable $e) {
            logger($e->getMessage());
        }

        return $result;
    }

    /**
     * @param int|null $bankId
     * @param string|null $refresh
     * @return Collection|Template
     */
    public function front(
        int $bankId = null,
        string $refresh = null
    ) {
        try {
            $query = Bank::query()
                ->with([
                    'template' => function (Relation $builder) {
                        $builder->where('status', StatusConstants::YES);
                    }
                ]);
            if (!is_null($bankId)) {
                $query->where('id', $bankId);
            }
            if (!is_null($refresh)) {
                $query->where('updated_at', '>=', $refresh)
                    ->orWhereHas('template', function (Builder $builder) use ($refresh) {
                        $builder->where('template.updated_at', '>=', $refresh);
                    });
            }
            $result = $query->get();
        } catch (\Throwable $e) {
            $result = collect();
            logger($e->getMessage());
        }

        return $result;
    }
}
