<?php

namespace Thotam\ThotamBuddy\Models;

use Thotam\ThotamHr\Models\HR;
use Thotam\ThotamTeam\Models\Nhom;
use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Thotam\ThotamBuddy\Models\BuddyDuyet;
use Thotam\ThotamBuddy\Models\BuddyDanhGia;
use Thotam\ThotamBuddy\Models\BuddyTieuChi;
use Illuminate\Database\Eloquent\SoftDeletes;
use Thotam\ThotamBuddy\Models\BuddyTrangThai;
use Thotam\ThotamBuddy\Models\BuddyTieuChiDuyet;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'ngayvaolam' => 'datetime',
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

    /**
     * Get the buddy_duyet associated with the Buddy
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function buddy_duyet(): HasOne
    {
        return $this->hasOne(BuddyDuyet::class, 'buddy_id', 'id');
    }

    /**
     * The nguoihuongdans that belong to the Buddy
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function nguoihuongdans(): BelongsToMany
    {
        return $this->belongsToMany(HR::class, 'buddy_nguoihuongdans', 'buddy_id', 'hr_key');
    }

    /**
     * Get all of the buddy_tieuchies for the Buddy
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function buddy_tieuchies(): HasMany
    {
        return $this->hasMany(BuddyTieuChi::class, 'buddy_id', 'id');
    }

    /**
     * Get all of the buddy_tieuchi_duyet for the Buddy
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function buddy_tieuchi_duyet(): HasOne
    {
        return $this->hasOne(BuddyTieuChiDuyet::class, 'buddy_id', 'id');
    }

    /**
     * Get the buddy_danhgia associated with the Buddy
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function buddy_danhgia(): HasOne
    {
        return $this->hasOne(BuddyDanhGia::class, 'buddy_id', 'id');
    }
}
