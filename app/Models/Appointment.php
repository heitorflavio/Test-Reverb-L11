<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'calendar_id',
        'title',
        'description',
        'start',
        'end',
        'color',
        'status',
    ];

    public function calendar()
    {
        return $this->belongsTo(Calendar::class);
    }
}
