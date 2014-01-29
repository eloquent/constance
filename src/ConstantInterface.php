<?php

/*
 * This file is part of the Constance package.
 *
 * Copyright © 2014 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eloquent\Constance;

use Eloquent\Enumeration\ValueMultitonInterface;

/**
 * The interface implemented by constant instances.
 */
interface ConstantInterface extends ValueMultitonInterface
{
    /**
     * Get the name of this constant.
     *
     * @return string The constant name.
     */
    public function name();

    /**
     * Get the fully qualified name of this constant.
     *
     * @return string The qualified constant name.
     */
    public function qualifiedName();

    /**
     * Returns true if this constant's value matches the supplied bitmask.
     *
     * @param integer $mask The mask to test against.
     *
     * @return boolean                            True if the value matches.
     * @throws Exception\NonIntegerValueException If this constant's value is not an integer.
     */
    public function valueMatchesBitmask($mask);
}
