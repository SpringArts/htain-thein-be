<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralOutcome extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function reporter()
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }
}
