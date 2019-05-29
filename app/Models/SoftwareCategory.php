<?php
/**
 * Created by PhpStorm.
 * User: funny
 * Date: 2019/5/24
 * Time: 下午 03:51
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SoftwareCategory extends Model
{
    protected $table = 'software_category';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function software()
    {
        return $this->hasMany(Software::class);
    }
}
