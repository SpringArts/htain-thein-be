<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Report
 *
 * @property int $id
 * @property int $amount
 * @property string|null $description
 * @property string|null $type
 * @property bool $confirm_status
 * @property int $reporter_id reporter
 * @property int|null $verifier_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ReportEditHistory> $editHistory
 * @property-read int|null $edit_history_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\NotiInfo> $noti
 * @property-read int|null $noti_count
 * @property-read \App\Models\User|null $reporter
 * @property-read \App\Models\User|null $verifier
 * @method static \Database\Factories\ReportFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Report newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Report newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Report query()
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereConfirmStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereReporterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereVerifierId($value)
 * @mixin \Eloquent
 */
class Report extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $casts = [
        'amount' => 'integer',
        'confirm_status' => 'boolean',
        'reporter_id' => 'integer',
        'verifier_id' => 'integer',
    ];

    public function reporter()
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verifier_id');
    }

    public function noti()
    {
        return $this->hasMany(NotiInfo::class);
    }

    public function editHistory()
    {
        return $this->hasMany(ReportEditHistory::class);
    }
}
