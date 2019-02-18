<?php

namespace App\Http\Requests\Information\Publish;

use App\Constants\Roles\RolesConstants;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InformationManageStoreRequest extends FormRequest
{
    /**
     * @return string
     */
    public function getSubject()
    {
        return $this->get('subject');
    }

    /**
     * @return int
     */
    public function getCategoryId()
    {
        return $this->get('category_id');
    }

    /**
     * @return array
     */
    public function getRole()
    {
        return $this->get('role');
    }

    /**
     * @return string|null
     */
    public function getInfoContent()
    {
        return $this->get('content', null);
    }

    /**
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'subject'     => 'required|string',
            'category_id' => 'required|integer|' . Rule::exists('information_category', 'id'),
            'role'        => 'required|array|',
            'role.*'      => 'required|string|' . Rule::in(RolesConstants::enum()),
            'content'     => 'sometimes|required'
        ];
    }
}
