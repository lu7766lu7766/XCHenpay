<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class InformationCategoryModel
 * @package App\Models
 * @property InformationNotify[]|Collection informationArticle
 */
class InformationCategory extends Model
{
    protected $table = 'information_category';
    protected $fillable = [
        'code'
    ];

    /**
     * @return HasMany
     */
    public function informationArticle()
    {
        return $this->hasMany(InformationNotify::class, 'category_id');
    }
}
