<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'service';
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id',
        'title',
        'price',
        'currency_id',
        'first_payment_time',
        'last_payment_time',
        'status'
    ];


    public function first_payment_time()
    {
        $first_payment_time = $this->first_payment_time;
        $first_payment_time = strftime("%e %B %Y %A", strtotime($first_payment_time));
        return $first_payment_time;
    }


    public function last_payment_time()
    {
        $last_payment_time = $this->last_payment_time;
        $last_payment_time = strftime("%e %B %Y %A", strtotime($last_payment_time));
        return $last_payment_time;
    }

    public function next_payment_time()
    {
        $next_payment_time = date('Y-m-d', strtotime(date("Y-m-d", strtotime($this->last_payment_time)) . " + 365 day"));
        $next_payment_time_array['en'] = $next_payment_time;
        setlocale(LC_ALL, 'tr_TR.UTF-8');
        $next_payment_time = strftime("%e %B %Y %A", strtotime($next_payment_time));
        $next_payment_time_array['tr'] = $next_payment_time;

        return $next_payment_time_array;
    }

    public function days_left()
    {
        $next_payment_time = $this->next_payment_time()['en'];
        $days_left = (strtotime($next_payment_time) - strtotime(date("Y-m-d"))) / 60 / 60 / 24;
        return $days_left;
    }

    public function currency()
    {
        return $this->hasOne(Currency::class, 'id', 'currency_id');
    }

    public function company()
    {
        return $this->hasOne(Company::class, 'id', 'company_id');
    }
}
