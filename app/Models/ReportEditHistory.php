<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportEditHistory extends Model
{
    use HasFactory;
    protected $guarded = ['id'];


    public function report()
    {
        return $this->belongsTo(Report::class, 'report_id');
    }

    public function editUser()
    {
        return $this->belongsTo(User::class, 'editor_id');
    }
}
