<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class InformationCategoryModel
 * @package App\Models
 */
class InformationCategory extends Model
{
    protected $table = 'information_category';
    protected $fillable = [
        'code'
    ];
}
