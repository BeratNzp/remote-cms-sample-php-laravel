<?php

namespace App\Models\RCMS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\RCMS\Company;

class Department extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'department';
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'company_id'
    ];

    public function company()
    {
        if ($this->company_id) {
            $company = Company::where('id', $this->company_id)->first();
            return $company;
        } else
            return false;
    }
}
