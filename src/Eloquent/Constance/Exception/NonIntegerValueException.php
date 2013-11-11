<?php

/*
 * This file is part of the Constance package.
 *
 * Copyright © 2013 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eloquent\Constance\Exception;

use Exception;

/**
 * A non-integer value was encountered.
 */
final class NonIntegerValueException extends Exception
{
    /**
     * Construct a new non-integer value exception.
     *
     * @param mixed          $value The non-integer value.
     * @param Exception|null $cause The cause, if available.
     */
    public function __construct($value, Exception $cause = null)
    {
        $this->value = $value;

        parent::__construct(
            sprintf(
                'Non-integer value %s encountered.',
                var_export($value, true)
            ),
            0,
            $cause
        );
    }

    /**
     * Get the non-integer value
     *
     * @return mixed The non-integer value
     */
    public function value()
    {
        return $this->value;
    }

    private $value;
}
