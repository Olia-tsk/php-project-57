<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskStatus extends Model
{
    use HasFactory;

    public const STATUSES = ['новый', 'в работе', 'на тестировании', 'завершен'];

    protected $fillable = ['name'];

    public function tasks()
    {
        return $this->hasMany(Task::class, 'status_id');
    }

    public function getCreatedAtAttribute($date): string
    {
        return $date ? Carbon::parse($date)->format('d.m.Y') : '';
    }

    public static function getStatuses()
    {
        return self::pluck('name', 'id')->toArray();
    }
}
