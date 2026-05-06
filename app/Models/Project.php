<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'deadline',
    ];

    protected $casts = [
        'deadline' => 'date',
    ];

    /**
     * Mutator: automatically store title in ucfirst (bonus requirement)
     */
    public function setTitleAttribute($value): void
    {
        $this->attributes['title'] = ucfirst(trim($value));
    }

    /**
     * Many-to-many relationship with User via pivot project_user (role column)
     */
    public function users()
    {
        return $this->belongsToMany(User::class)
                    ->withPivot('role')
                    ->withTimestamps();
    }

    /**
     * One-to-many relationship with Task
     */
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}