<?php
/**
 * Created by PhpStorm.
 * User: House
 * Date: 2018/12/26
 * Time: 下午 04:20
 */

namespace App\Repositories;

use App\Constants\Roles\RolesConstants;
use App\Constants\TradeTypesConstants;
use App\Models\Authcode;
use App\Models\Currency;
use App\Models\Payment;
use App\Models\TradeType;
use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;

class FillOrderRepo
{
    /**
     * @return Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection
     */
    public function allMerchant()
    {
        try {
            $result = User::query()
                ->whereHas('roles', function (Builder $builder) {
                    $builder->where('slug', RolesConstants::USER);
                })
                ->get([
                    'id',
                    'company_service_id',
                    'email',
                    'QQ_id',
                    'mobile',
                    'company_name',
                ]);
        } catch (\Throwable $e) {
            $result = collect();
            logger($e->getMessage());
        }

        return $result;
    }

    /**
     * @param int $userId
     * @return User|null
     */
    public function findMerchantByUserId(int $userId)
    {
        try {
            $result = User::query()
                ->whereHas('roles', function (Builder $builder) {
                    $builder->where('slug', RolesConstants::USER);
                })
                ->where('id', $userId)->first();
        } catch (\Throwable $e) {
            $result = null;
            logger($e->getMessage());
        }

        return $result;
    }

    /**
     * Get a order from db when exist or new order when id is null, return null when id not found.
     * @param string $key
     * @param int|null $id
     * @param array $data
     * @return Authcode|\Illuminate\Database\Eloquent\Model|null
     */
    public function saveOrder(string $key, int $id = null, array $data = [])
    {
        try {
            if (is_null($id)) {
                $result = new Authcode();
            } else {
                $result = Authcode::query()->whereHas('tradeType', function (Builder $builder) {
                    $builder->where('name', TradeTypesConstants::FILL_ORDER);
                })->find($id);
            }
            if (!is_null($result)) {
                $result->fill($data)->fillCopyTime()->save();
                $this->generateTradeSeq($result, $key);
            }
        } catch (\Throwable $e) {
            $result = null;
            logger($e->getMessage());
        }

        return $result;
    }

    /**
     * @param Authcode $order
     * @param string $key
     * @return bool
     */
    private function generateTradeSeq(Authcode $order, string $key)
    {
        try {
            $order->trade_seq = md5($key . $order->getKey());
            $result = $order->save();
        } catch (\Throwable $e) {
            $result = false;
        }

        return $result;
    }

    /**
     * @return TradeType|null
     */
    public function getFillTradeType()
    {
        try {
            $result = TradeType::query()->where('name', TradeTypesConstants::FILL_ORDER)->first();
        } catch (\Throwable $e) {
            $result = null;
            logger($e->getMessage());
        }

        return $result;
    }

    /**
     * @return Currency|null
     */
    public function getDefaultCurrency()
    {
        try {
            $result = Currency::query()->first();
        } catch (\Throwable $e) {
            $result = null;
            logger($e->getMessage());
        }

        return $result;
    }

    /**
     * @param string $start
     * @param string $end
     * @param string $companyServiceId
     * @param int|null $payment
     * @param int|null $payState
     * @param string|null $keyword
     * @param int $page
     * @param int $perpage
     * @return Authcode[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getList(
        string $start,
        string $end,
        string $companyServiceId = null,
        int $payment = null,
        int $payState = null,
        string $keyword = null,
        int $page = 1,
        int $perpage = 20
    ) {
        try {
            $builder = Authcode::with([
                'company' => function (Relation $relation) {
                    $relation->select([
                        'id',
                        'company_service_id',
                        'email',
                        'QQ_id',
                        'mobile',
                        'company_name',
                    ]);
                },
                'payment'
            ]);
            if (!is_null($companyServiceId)) {
                $builder->where('company_service_id', $companyServiceId);
            }
            $builder->whereHas('company', function (Builder $builder) {
                $builder->whereHas('roles', function (Builder $builder) {
                    $builder->where('slug', RolesConstants::USER);
                });
            })->whereHas('tradeType', function (Builder $builder) {
                $builder->where('name', TradeTypesConstants::FILL_ORDER);
            });
            if (!is_null($payment)) {
                $builder->where('payment_type', $payment);
            }
            if (!is_null($payState)) {
                $builder->where('pay_state', $payState);
            }
            if (!is_null($keyword)) {
                $builder->where(function (Builder $builder) use ($keyword) {
                    $builder->where('trade_seq', $keyword)->orWhere('trade_service_id', $keyword);
                });
            }
            $result = $builder->whereBetween('created_at', [$start, $end])
                ->forPage($page, $perpage)
                ->get();
        } catch (\Throwable $e) {
            $result = collect();
            logger($e->getMessage());
        }

        return $result;
    }

    /**
     * @param string $start
     * @param string $end
     * @param string $companyServiceId
     * @param int|null $payment
     * @param int|null $payState
     * @param string|null $keyword
     * @return int
     */
    public function total(
        string $start,
        string $end,
        string $companyServiceId = null,
        int $payment = null,
        int $payState = null,
        string $keyword = null
    ) {
        try {
            $builder = Authcode::query();
            if (!is_null($companyServiceId)) {
                $builder->where('company_service_id', $companyServiceId);
            }
            $builder->whereHas('company', function (Builder $builder) {
                $builder->whereHas('roles', function (Builder $builder) {
                    $builder->where('slug', RolesConstants::USER);
                });
            })->whereHas('tradeType', function (Builder $builder) {
                $builder->where('name', TradeTypesConstants::FILL_ORDER);
            });
            if (!is_null($payment)) {
                $builder->where('payment_type', $payment);
            }
            if (!is_null($payState)) {
                $builder->where('pay_state', $payState);
            }
            if (!is_null($keyword)) {
                $builder->where(function (Builder $builder) use ($keyword) {
                    $builder->where('trade_seq', $keyword)->orWhere('trade_service_id', $keyword);
                });
            }
            $result = $builder->whereBetween('created_at', [$start, $end])
                ->count();
        } catch (\Throwable $e) {
            $result = 0;
            logger($e->getMessage());
        }

        return $result;
    }

    /**
     * @param int $id
     * @return Authcode|null
     */
    public function find(int $id)
    {
        try {
            $result = Authcode::with([
                'company' => function (Relation $relation) {
                    $relation->select([
                        'id',
                        'company_service_id',
                        'email',
                        'QQ_id',
                        'mobile',
                        'company_name',
                    ]);
                },
                'payment'
            ])
                ->where('id', $id)
                ->whereHas('company', function (Builder $builder) {
                    $builder->whereHas('roles', function (Builder $builder) {
                        $builder->where('slug', RolesConstants::USER);
                    });
                })
                ->whereHas('tradeType', function (Builder $builder) {
                    $builder->where('name', TradeTypesConstants::FILL_ORDER);
                })->first();
        } catch (\Throwable $e) {
            $result = null;
            logger($e->getMessage());
        }

        return $result;
    }

    /**
     * @param array $except
     * @return \Illuminate\Database\Eloquent\Collection|Payment[]
     */
    public function getPayment(array $except = [])
    {
        try {
            $result = Payment::query()->whereNotIn('i6pay_id', $except)->get();
        } catch (\Throwable $e) {
            $result = collect();
            logger($e->getMessage());
        }

        return $result;
    }
}
