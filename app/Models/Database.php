<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\RCMS\Company;

class Database extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'database';
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id',
        'ip',
        'port',
        'username',
        'password',
        'database',
    ];

    public function company()
    {
        return $this->hasOne(Company::class, 'id', 'company_id');
    }
}
