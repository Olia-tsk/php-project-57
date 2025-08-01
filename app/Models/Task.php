<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property \Illuminate\Database\Eloquent\Collection|Label[] $labels
 * @method \Illuminate\Database\Eloquent\Relations\BelongsToMany labels()
 */
class Task extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'status_id', 'created_by_id', 'assigned_to_id'];

    public function getFormattedCreatedAtAttribute(): string
    {
        return $this->created_at ? \Carbon\Carbon::parse($this->created_at)->format('d.m.Y') : '';
    }

    public function status()
    {
        return $this->belongsTo(TaskStatus::class, 'status_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to_id');
    }

    public function labels()
    {
        return $this->belongsToMany(Label::class);
    }

    public function getLabelIds()
    {
        return $this->labels->pluck('id')->toArray();
    }
}
