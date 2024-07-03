<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\CancelReportHistory
 *
 * @property int $id
 * @property int $amount
 * @property string|null $description
 * @property string|null $type
 * @property int $reporter_id reporter
 * @property int|null $rejecter_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $rejecter
 * @method static \Database\Factories\CancelReportHistoryFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|CancelReportHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CancelReportHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CancelReportHistory query()
 * @method static \Illuminate\Database\Eloquent\Builder|CancelReportHistory whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CancelReportHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CancelReportHistory whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CancelReportHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CancelReportHistory whereRejecterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CancelReportHistory whereReporterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CancelReportHistory whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CancelReportHistory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CancelReportHistory extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function rejecter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'rejecter_id');
    }
}
