<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $email_verified_at
 * @property string $password
 * @property string $account_status
 * @property string|null $role
 * @property string|null $provider_name
 * @property string|null $provider_id
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ReportEditHistory> $editReportHistory
 * @property-read int|null $edit_report_history_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\NotiInfo> $noti
 * @property-read int|null $noti_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\GeneralOutcome> $regularCostReport
 * @property-read int|null $regular_cost_report_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\CancelReportHistory> $reportHistory
 * @property-read int|null $report_history_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Report> $reportedReports
 * @property-read int|null $reported_reports_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Report> $verifiedReports
 * @property-read int|null $verified_reports_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAccountStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereProviderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereProviderName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

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
        return $this->hasMany(NotiInfo::class);
    }

    public function regularCostReport()
    {
        return $this->hasMany(GeneralOutcome::class, 'reporter_id');
    }
}
