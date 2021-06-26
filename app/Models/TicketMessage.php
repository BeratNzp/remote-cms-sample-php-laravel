<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TicketMessage extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'ticket';
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'message',
        'department_id',
    ];

    public function department()
    {
        return $this->hasOne(Department::class, 'id', 'department_id');
    }
    public function messages()
    {
        return $this->hasMany(TicketMessage::class, 'ticket_id', 'id');
    }
}
