<?php
/**
 * Created by PhpStorm.
 * User: Jac
 * Date: 2019/03/18
 * Time: 下午 05:32
 */

namespace App\Http\Controllers\FrondEnd;

use App\Http\Controllers\Controller;

class DescriptionController extends Controller
{
    /**
     * alipay 說明頁
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function alipay()
    {
        return view('admin.description.alipay');
    }
}
