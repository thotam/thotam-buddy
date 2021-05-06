<?php

namespace Thotam\ThotamBuddy\Models;

use Thotam\ThotamHr\Models\HR;
use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Thotam\ThotamBuddy\Models\BuddyTrangThai;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BuddyTieuChiDuyet extends Model
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
    protected $table = 'buddy_tieuchi_duyets';

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
     * Get the ketqua_duyet that owns the Buddy
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ketqua_duyet(): BelongsTo
    {
        return $this->belongsTo(BuddyTrangThai::class, 'ketqua', 'id');
    }
}
