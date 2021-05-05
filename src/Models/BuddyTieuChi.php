<?php

namespace Thotam\ThotamBuddy\Models;

use Thotam\ThotamHr\Models\HR;
use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BuddyTieuChi extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Userstamps;

    /**
     * Disable Laravel's mass assignment protection
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'buddy_tieuchis';


    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'deadline' => 'datetime',
    ];

    /**
     * Get the hr that owns the Buddy
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function hr(): BelongsTo
    {
        return $this->belongsTo(HR::class, 'hr_key', 'key');
    }
}
