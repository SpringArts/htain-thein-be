<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\NotiInfo
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $report_id
 * @property int|null $announcement_id
 * @property string $firebase_notification_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Announcement|null $announcement
 * @property-read \App\Models\Report|null $report
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\NotiInfoFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|NotiInfo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NotiInfo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NotiInfo query()
 * @method static \Illuminate\Database\Eloquent\Builder|NotiInfo whereAnnouncementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotiInfo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotiInfo whereFirebaseNotificationId($value)
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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function report(): BelongsTo
    {
        return $this->belongsTo(Report::class);
    }

    public function announcement(): BelongsTo
    {
        return $this->belongsTo(Announcement::class);
    }
}
