<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\FeeList\FeeListInfoRequest;
use App\Service\FeeListService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Validation\ValidationException;

class FeeListController extends Controller
{
    /**
     * @return Factory
     */
    public function indexView()
    {
        return view('admin.fee.list');
    }

    /**
     * @return array
     */
    public function index()
    {
        return ['data' => FeeListService::getInstance(\Sentinel::getUser())->list()];
    }

    /**
     * @param $id
     * @return array
     * @throws ValidationException
     */
    public function info($id)
    {
        return [
            'data' => FeeListService::getInstance(\Sentinel::getUser())
                ->info(FeeListInfoRequest::getHandle(['id' => $id]))
        ];
    }
}
