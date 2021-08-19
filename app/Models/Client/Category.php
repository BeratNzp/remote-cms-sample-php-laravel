<?php

namespace App\Models\Client;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;
    protected $connection = 'panel_user';
    protected $table = 'category';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'up_category_id',
        'type_id',
        'title',
        'can_sub_category',
        'main_category',
    ];

    public function up_category()
    {
        return $this->hasOne(Category::class, 'id', 'up_category_id');
    }

    public function count_of_sub_category()
    {
        return $this->hasMany(Category::class, 'up_category_id', 'id')->count();
    }
}
