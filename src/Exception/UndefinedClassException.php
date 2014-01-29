<?php

/*
 * This file is part of the Constance package.
 *
 * Copyright © 2014 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eloquent\Constance\Exception;

use Exception;

/**
 * An undefined class name was specified.
 */
final class UndefinedClassException extends Exception
{
    /**
     * Construct a new undefined class exception.
     *
     * @param string|null    $className The undefined class name.
     * @param Exception|null $cause     The cause, if available.
     */
    public function __construct($className, Exception $cause = null)
    {
        $this->className = $className;

        parent::__construct(
            sprintf('Undefined class %s.', var_export($className, true)),
            0,
            $cause
        );
    }

    /**
     * Get the undefined class name.
     *
     * @return string|null The undefined class name.
     */
    public function className()
    {
        return $this->className;
    }

    private $className;
}
