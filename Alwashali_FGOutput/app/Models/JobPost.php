<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'salary_from',
        'salary_to',
        'apply_until',
        'social',
        'hirer_id',
        'requirement_id',
    ];

    public function requirement(){
        return $this->hasOne(Requirement::class, 'id', 'requirement_id');
    }

    public function applied() {
        return $this->hasMany(JobApplied::class, 'job_id');
    }
}