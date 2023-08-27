<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'remember_token',
    ];

    public function reportedReports()
    {
        return $this->hasMany(Report::class, 'reporter_id');
    }

    public function verifiedReports()
    {
        return $this->hasMany(Report::class, 'verifier_id');
    }

    public function reportHistory()
    {
        return $this->hasMany(CancelReportHistory::class, 'rejecter_id');
    }

    public function editReportHistory()
    {
        return $this->hasMany(ReportEditHistory::class, 'editor_id');
    }

    public function noti()
    {
        return $this->hasMany(Notification::class);
    }

    public function regularCostReport()
    {
        return $this->hasMany(GeneralOutcome::class, 'reporter_id');
    }
}
