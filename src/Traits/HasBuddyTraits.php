<?php

namespace Thotam\ThotamBuddy\Traits;

use Thotam\ThotamBuddy\Models\Buddy;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait HasBuddyTraits
{
    /**
     * The nguoihuongdan_of_buddies that belong to the HasBuddyTraits
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function nguoihuongdan_of_buddies(): BelongsToMany
    {
        return $this->belongsToMany(Buddy::class, 'buddy_nguoihuongdans', 'hr_key', 'buddy_id');
    }

    public function getNguoihuongdanOfBuddyIdsAttribute()
    {
        return $this->nguoihuongdan_of_buddies->pluck("id");
    }
}
