<?php
/**
 * Created by PhpStorm.
 * User: funny
 * Date: 2019/5/24
 * Time: 下午 03:54
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Software extends Model
{
    protected $table = 'software';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(SoftwareCategory::class, 'software_category_id');
    }
}
