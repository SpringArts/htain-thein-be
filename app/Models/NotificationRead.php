<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $user_id
 * @property int $noti_info_id
 * @property \Illuminate\Support\Carbon|null $read_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Announcement|null $announcement
 * @property-read \App\Models\NotiInfo $notiInfo
 * @property-read \App\Models\User $user
 *
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationRead newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationRead newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationRead query()
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationRead whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationRead whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationRead whereNotiInfoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationRead whereReadAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationRead whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationRead whereUserId($value)
 *
 * @mixin \Eloquent
 */
class NotificationRead extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'noti_info_id',
        'read_at',
    ];


    protected $casts = [
        'read_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function announcement(): BelongsTo
    {
        return $this->belongsTo(Announcement::class);
    }

    public function notiInfo(): BelongsTo
    {
        return $this->belongsTo(NotiInfo::class);
    }

    public function scopeMarkAsRead($query)
    {
        return $query->update(['read_at' => now()]);
    }
}
