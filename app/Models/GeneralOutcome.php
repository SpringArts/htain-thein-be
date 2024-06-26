<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\GeneralOutcome
 *
 * @property int $id
 * @property int $reporter_id
 * @property string $description
 * @property int $amount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $reporter
 *
 * @method static \Database\Factories\GeneralOutcomeFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|GeneralOutcome newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GeneralOutcome newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GeneralOutcome query()
 * @method static \Illuminate\Database\Eloquent\Builder|GeneralOutcome whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GeneralOutcome whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GeneralOutcome whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GeneralOutcome whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GeneralOutcome whereReporterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GeneralOutcome whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class GeneralOutcome extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function reporter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }
}
