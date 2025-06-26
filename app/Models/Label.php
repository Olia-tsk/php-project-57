<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 */
class Label extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    public function tasks()
    {
        return $this->belongsToMany(Task::class);
    }

    public function getCreatedAtAttribute($date): string
    {
        return $date ? Carbon::parse($date)->format('d.m.Y') : '';
    }

    public static function getLabels()
    {
        return self::pluck('name', 'id')->toArray();
    }
}
