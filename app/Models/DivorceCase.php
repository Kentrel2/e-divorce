<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DivorceCase extends Model
{
    protected $table = 'divorce_cases';

    protected $fillable = [
        'case_number',
        'petitioner_name',
        'respondent_name',
        'status',
        'description',
        'user_id',
        'judge_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function judge()
    {
        return $this->belongsTo(User::class, 'judge_id');
    }
}
