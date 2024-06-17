<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Announcement
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string $content
 * @property int $is_visible
 * @property string $priority 1: low, 2: medium, 3: high
 * @property int $user_id
 * @property string $due_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $announcer
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\NotiInfo> $noti
 * @property-read int|null $noti_count
 *
 * @method static \Database\Factories\AnnouncementFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Announcement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Announcement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Announcement query()
 * @method static \Illuminate\Database\Eloquent\Builder|Announcement whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Announcement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Announcement whereDueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Announcement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Announcement whereIsVisible($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Announcement wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Announcement whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Announcement whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Announcement whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Announcement whereUserId($value)
 *
 * @mixin \Eloquent
 */
class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'is_visible',
        'priority',
        'user_id',
        'due_date',
    ];

    public function announcer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function noti(): HasMany
    {
        return $this->hasMany(NotiInfo::class);
    }
}
