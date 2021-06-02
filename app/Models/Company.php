<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Department;

class Company extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'company';
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'company_title'
    ];

    public function departments()
    {
        return $this->hasMany(Department::class, 'company_id', 'id');
    }
}
