<?php

namespace Thotam\ThotamBuddy\Models;

use Thotam\ThotamHr\Models\HR;
use Thotam\ThotamTeam\Models\Nhom;
use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Thotam\ThotamBuddy\Models\BuddyTrangThai;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Buddy extends Model
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
    protected $table = 'buddies';

    /**
     * Get the hr that owns the Buddy
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function hr(): BelongsTo
    {
        return $this->belongsTo(HR::class, 'hr_key', 'key');
    }

    /**
     * Get the nhom that owns the Buddy
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function nhom(): BelongsTo
    {
        return $this->belongsTo(Nhom::class, 'nhom_id', 'id');
    }

    /**
     * Get the trangthai that owns the Buddy
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function trangthai(): BelongsTo
    {
        return $this->belongsTo(BuddyTrangThai::class, 'trangthai_id', 'id');
    }
}
