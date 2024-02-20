<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $casts = [
        'amount' => 'integer',
        'confirm_status' => 'boolean',
        'reporter_id' => 'integer',
        'verifier_id' => 'integer',
    ];

    public function reporter()
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verifier_id');
    }

    public function noti()
    {
        return $this->hasMany(NotiInfo::class);
    }

    public function editHistory()
    {
        return $this->hasMany(ReportEditHistory::class);
    }
}
