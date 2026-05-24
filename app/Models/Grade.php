<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $fillable = [
        'student_id',
        'subject_id',
        'faculty_id',
        'semester',
        'academic_year',
        'prelim',
        'midterm',
        'final',
        'average',
        'remarks',
        'status',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($grade) {
            if ($grade->prelim !== null && $grade->midterm !== null && $grade->final !== null) {
                // 30% Prelim, 30% Midterm, 40% Final
                $grade->average = ($grade->prelim * 0.3) + ($grade->midterm * 0.3) + ($grade->final * 0.4);
                
                if (!$grade->remarks || $grade->remarks === 'In Progress') {
                    $grade->remarks = $grade->average >= 75 ? 'Pass' : 'Fail';
                }
            } else {
                $grade->average = null;
                $grade->remarks = 'In Progress';
            }
        });

        static::created(function ($grade) {
            GradeLog::create([
                'grade_id' => $grade->id,
                'user_id' => auth()->id() ?? 1, // Fallback to 1 for seeders
                'action' => 'Created',
                'new_values' => $grade->getAttributes(),
            ]);
        });

        static::updated(function ($grade) {
            GradeLog::create([
                'grade_id' => $grade->id,
                'user_id' => auth()->id() ?? 1,
                'action' => 'Updated',
                'old_values' => $grade->getOriginal(),
                'new_values' => $grade->getChanges(),
            ]);
        });

        static::deleted(function ($grade) {
            GradeLog::create([
                'grade_id' => $grade->id,
                'user_id' => auth()->id() ?? 1,
                'action' => 'Deleted',
                'old_values' => $grade->getAttributes(),
            ]);
        });
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }
}
