<?php
/**
 * Created by PhpStorm.
 * User: funny
 * Date: 2019/5/9
 * Time: 下午 02:26
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    protected $table = 'template';
    protected $fillable = [
        'contents',
        'status'
    ];
    protected $casts = ['contents' => 'json'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function bank()
    {
        return $this->belongsToMany(Bank::class, 'bank_template', 'template_id', 'bank_id');
    }
}
