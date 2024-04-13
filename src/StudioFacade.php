<?php

namespace Componentstudio\Studio;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Componentstudio\Studio\Skeleton\SkeletonClass
 */
class StudioFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'studio';
    }
}
