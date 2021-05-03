<?php

namespace Thotam\ThotamBuddy;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Thotam\ThotamBuddy\Skeleton\SkeletonClass
 */
class ThotamBuddyFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'thotam-buddy';
    }
}
