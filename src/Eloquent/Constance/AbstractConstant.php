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

use Eloquent\Enumeration\AbstractValueMultiton;

/**
 * An abstract base class for implementing constants as enumerations.
 */
abstract class AbstractConstant extends AbstractValueMultiton implements
    ConstantInterface
{
    /**
     * The expression used to match constant names that should be included in
     * this enumeration.
     */
    const CONSTANCE_PATTERN = null;

    /**
     * Get all members whose values match the supplied bitmask.
     *
     * @param integer $mask The bitmask to use when searching.
     *
     * @return array<ConstantInterface>           The matching members.
     * @throws Exception\NonIntegerValueException If any member's value is a non-integer.
     */
    final public static function membersByBitmask($mask)
    {
        return static::membersByPredicate(
            function (ConstantInterface $member) use ($mask) {
                return $member->valueMatchesBitmask($mask);
            }
        );
    }

    /**
     * Get all members whose values do not match the supplied bitmask.
     *
     * @param integer $mask The bitmask to use when searching.
     *
     * @return array<ConstantInterface>           The non-matching members.
     * @throws Exception\NonIntegerValueException If any member's value is a non-integer.
     */
    final public static function membersExcludedByBitmask($mask)
    {
        return static::membersByPredicate(
            function (ConstantInterface $member) use ($mask) {
                return !$member->valueMatchesBitmask($mask);
            }
        );
    }

    /**
     * Generates a bitmask representing the suppled members.
     *
     * @param mixed<ConstantInterface> $members The members to create a bitmask for.
     *
     * @return integer                            The bitmask representing the supplied members.
     * @throws Exception\NonIntegerValueException If any member's value is a non-integer.
     */
    final public static function membersToBitmask($members)
    {
        $mask = 0;
        foreach ($members as $member) {
            if (!is_integer($member->value())) {
                throw new Exception\NonIntegerValueException($member->value());
            }

            $mask |= $member->value();
        }

        return $mask;
    }

    /**
     * Get the name of this constant.
     *
     * @return string The constant name.
     */
    public function name()
    {
        return $this->key();
    }

    /**
     * Returns true if this constant's value matches the supplied bitmask.
     *
     * @param integer $mask The mask to test against.
     *
     * @return boolean                            True if the value matches.
     * @throws Exception\NonIntegerValueException If this constant's value is not an integer.
     */
    public function valueMatchesBitmask($mask)
    {
        if (!is_integer($this->value())) {
            throw new Exception\NonIntegerValueException($this->value());
        }

        return $this->value() === ($this->value() & $mask);
    }

    /**
     * Returns a string representation of this constant.
     *
     * @return string The string representation.
     */
    public function __toString()
    {
        return $this->qualifiedName();
    }
}
