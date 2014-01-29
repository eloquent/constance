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

use Eloquent\Enumeration\Exception\AbstractUndefinedMemberException;
use Exception;

/**
 * An undefined global constant was requested.
 */
final class UndefinedGlobalConstantException
    extends AbstractUndefinedMemberException
    implements UndefinedConstantExceptionInterface
{
    /**
     * Construct a new undefined class constant exception.
     *
     * @param string         $className The name of the class to which the constant belongs.
     * @param string         $property  The name of the property used to search for the member.
     * @param mixed          $value     The value of the property used to search for the member.
     * @param Exception|null $cause     The cause, if available.
     */
    public function __construct(
        $className,
        $property,
        $value,
        Exception $cause = null
    ) {
        parent::__construct(
            sprintf(
                'No global constant with %s equal to %s is defined in class %s.',
                $property,
                var_export($value, true),
                var_export($className, true)
            ),
            $className,
            $property,
            $value,
            $cause
        );
    }

}
