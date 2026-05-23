<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    protected $fillable = [
        'user_id',
        'employee_id',
        'department',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($faculty) {
            if (!$faculty->employee_id) {
                $year = now()->format('Y');
                $latest = self::where('employee_id', 'LIKE', "FAC-$year-%")->orderBy('employee_id', 'desc')->first();
                $sequence = $latest ? (int) substr($latest->employee_id, -4) + 1 : 1;
                $faculty->employee_id = "FAC-$year-" . str_pad($sequence, 4, '0', STR_PAD_LEFT);
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class);
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }
}
