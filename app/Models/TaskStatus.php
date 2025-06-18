<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskStatus extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    public function getCreatedAtAttribute($date): string
    {
        return $date ? Carbon::parse($date)->format('d.m.Y') : '';
    }
}
