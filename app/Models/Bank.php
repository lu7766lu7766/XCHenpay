<?php
/**
 * Created by PhpStorm.
 * User: funny
 * Date: 2019/5/9
 * Time: 下午 02:22
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int id
 */
class Bank extends Model
{
    protected $table = 'bank';
    protected $fillable = [
        'code',
        'name',
        'swift_code',
        'status'
    ];
    protected $touches = ['template'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function template()
    {
        return $this->belongsToMany(Template::class, 'bank_template', 'bank_id', 'template_id');
    }
}
