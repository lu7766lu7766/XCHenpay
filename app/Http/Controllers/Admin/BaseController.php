<?php
/**
 * Created by PhpStorm.
 * User: ed
 * Date: 2018/11/1
 * Time: 上午 10:53
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

abstract class BaseController extends Controller
{
    /**
     * @var array
     */
    protected $req;

    public function __construct()
    {
        $this->req = request()->all();
    }

    /**
     * @return array
     */
    protected function getReq()
    {
        return $this->req;
    }
}
