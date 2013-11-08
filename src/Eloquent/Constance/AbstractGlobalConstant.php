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

use Exception as NativeException;

/**
 * An abstract base class for implementing global constants as enumerations.
 */
abstract class AbstractGlobalConstant extends AbstractConstant
{
    /**
     * Get the fully qualified name of this constant.
     *
     * @return string The qualified constant name.
     */
    public function qualifiedName()
    {
        return $this->name();
    }

    /**
     * Initializes the available constants.
     *
     * @throws Exception\UndefinedClassException If the specified class does not exist.
     */
    final protected static function initializeMembers()
    {
        foreach (get_defined_constants() as $key => $value) {
            if (preg_match(static::CONSTANCE_PATTERN, $key)) {
                new static($key, $value);
            }
        }
    }

    /**
     * Creates undefined constant exceptions.
     *
     * @param string               $className The class name.
     * @param string               $property  The property name.
     * @param mixed                $value     The value searched for.
     * @param NativeException|null $cause     The cause, if available.
     *
     * @return Exception\UndefinedGlobalConstantException The newly created exception.
     */
    protected static function createUndefinedMemberException(
        $className,
        $property,
        $value,
        NativeException $cause = null
    ) {
        if ('key' === $property) {
            $property = 'name';
        }

        return new Exception\UndefinedGlobalConstantException(
            $className,
            $property,
            $value,
            $cause
        );
    }
}
