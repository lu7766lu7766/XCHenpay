<?php

namespace App\Http\Requests\Whitelist;

use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class WhitelistStoreRequest extends FormRequest
{
    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->get('user_id');
    }

    /**
     * @return array
     */
    public function getIps()
    {
        return $this->get('ips');
    }

    /**
     * @inheritdoc
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * @inheritdoc
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => [
                'required',
                'integer',
                Rule::exists('users', 'id')->where(function (Builder $query) {
                    $query->where('deleted_at', null);
                })
            ],
            'ips'     => 'required|array',
            'ips.*'   => 'ip',
        ];
    }
}
