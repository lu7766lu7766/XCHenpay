<?php
/**
 * Created by PhpStorm.
 * User: funny
 * Date: 2019/5/24
 * Time: 下午 03:46
 */

namespace App\Service\Company\Software;

use App\Repositories\Company\Software\Download as Repo;
use App\Traits\Singleton;

class Download
{
    use Singleton;

    /**
     * @return \App\Models\SoftwareCategory|\Illuminate\Database\Eloquent\Collection
     */
    public function data()
    {
        return app(Repo::class)->getData();
    }
}
