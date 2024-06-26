<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\ReportEditHistory
 *
 * @property int $id
 * @property int $editor_id
 * @property int $report_id
 * @property string|null $old_data
 * @property string|null $new_data
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $editUser
 * @property-read \App\Models\Report $report
 *
 * @method static \Database\Factories\ReportEditHistoryFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|ReportEditHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ReportEditHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ReportEditHistory query()
 * @method static \Illuminate\Database\Eloquent\Builder|ReportEditHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReportEditHistory whereEditorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReportEditHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReportEditHistory whereNewData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReportEditHistory whereOldData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReportEditHistory whereReportId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReportEditHistory whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class ReportEditHistory extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function report(): BelongsTo
    {
        return $this->belongsTo(Report::class, 'report_id');
    }

    public function editUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'editor_id');
    }
}
