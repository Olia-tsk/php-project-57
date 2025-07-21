<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 */
class TaskStatus extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function tasks()
    {
        return $this->hasMany(Task::class, 'status_id');
    }

    public function getFormattedCreatedAtAttribute(): string
    {
        return $this->created_at ? \Carbon\Carbon::parse($this->created_at)->format('d.m.Y') : '';
    }

    public static function getStatuses()
    {
        return self::pluck('name', 'id')->toArray();
    }
}
