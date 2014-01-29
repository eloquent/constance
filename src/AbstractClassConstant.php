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

use Exception as NativeException;
use ReflectionClass;
use ReflectionException;

/**
 * An abstract base class for implementing class constants as enumerations.
 */
abstract class AbstractClassConstant extends AbstractConstant implements
    ClassConstantInterface
{
    /**
     * The class to inspect for constants.
     */
    const CONSTANCE_CLASS = null;

    /**
     * Get the fully qualified name of this constant.
     *
     * @return string The qualified constant name.
     */
    public function qualifiedName()
    {
        return sprintf('%s::%s', $this->className(), $this->name());
    }

    /**
     * Get the name of the class to which this constant belongs.
     *
     * @return string The class name.
     */
    public function className()
    {
        return static::CONSTANCE_CLASS;
    }

    /**
     * Initializes the available constants.
     *
     * @throws Exception\UndefinedClassException If the specified class does not exist.
     */
    final protected static function initializeMembers()
    {
        try {
            $reflector = new ReflectionClass(static::CONSTANCE_CLASS);
        } catch (ReflectionException $e) {
            throw new Exception\UndefinedClassException(
                static::CONSTANCE_CLASS,
                $e
            );
        }

        if (null === static::CONSTANCE_PATTERN) {
            foreach ($reflector->getConstants() as $key => $value) {
                new static($key, $value);
            }
        } else {
            foreach ($reflector->getConstants() as $key => $value) {
                if (preg_match(static::CONSTANCE_PATTERN, $key)) {
                    new static($key, $value);
                }
            }
        }
    }

    /**
     * Creates undefined class constant exceptions.
     *
     * @param string               $className The class name.
     * @param string               $property  The property name.
     * @param mixed                $value     The value searched for.
     * @param NativeException|null $cause     The cause, if available.
     *
     * @return Exception\UndefinedClassConstantException The newly created exception.
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

        return new Exception\UndefinedClassConstantException(
            $className,
            $property,
            $value,
            $cause
        );
    }
}
