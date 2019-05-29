<?php
/**
 * Created by PhpStorm.
 * User: funny
 * Date: 2019/5/24
 * Time: 下午 03:20
 */

namespace App\Http\Controllers\Company\Software;

use App\Http\Controllers\Controller;
use App\Service\Company\Software\Download;

class DownloadController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.download.software');
    }

    /**
     * @return \App\Models\SoftwareCategory|\Illuminate\Database\Eloquent\Collection
     */
    public function data()
    {
        return Download::getInstance()->data();
    }
}
