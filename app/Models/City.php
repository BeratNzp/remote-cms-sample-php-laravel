<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'city';
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'country_id',
        'title',
    ];

    public function country()
    {
        return $this->hasOne(Country::class, 'id', 'country_id');
    }
    public function counties()
    {
        return $this->hasMany(County::class, 'city_id', 'id');
    }
}
