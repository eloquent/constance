<?php

/*
 * This file is part of the Constance package.
 *
 * Copyright © 2013 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eloquent\Constance;

/**
 * The interface implemented by class constant instances.
 */
interface ClassConstantInterface extends ConstantInterface
{
    /**
     * Get the name of the class to which this constant belongs.
     *
     * @return string The class name.
     */
    public function className();
}
