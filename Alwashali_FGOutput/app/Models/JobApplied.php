<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplied extends Model
{
    use HasFactory;

    protected $table = 'jobs_applied';

    protected $fillable = [
        'candidate_id',
        'job_id',
        'status',
        'notify',
    ];

    public $timestamps = true;

    public function candidate(){
        return $this->hasOne(User::class, 'id', 'candidate_id');
    }

    public function qualifications(){
        return $this->hasMany(Qualification::class, 'candidate_id', 'candidate_id');
    }

    public function job(){
        return $this->belongsTo(JobPost::class, 'job_id');
    }
}
