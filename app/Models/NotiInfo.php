<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\NotiInfo
 *
 * @property int $id
 * @property int $user_id
 * @property int $report_id
 * @property int $check_status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Report $report
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\NotiInfoFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|NotiInfo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NotiInfo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NotiInfo query()
 * @method static \Illuminate\Database\Eloquent\Builder|NotiInfo whereCheckStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotiInfo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotiInfo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotiInfo whereReportId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotiInfo whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotiInfo whereUserId($value)
 * @mixin \Eloquent
 */
class NotiInfo extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function report()
    {
        return $this->belongsTo(Report::class);
    }
}
