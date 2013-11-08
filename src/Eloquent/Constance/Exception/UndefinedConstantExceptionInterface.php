<?php // @codeCoverageIgnoreStart

/*
 * This file is part of the Constance package.
 *
 * Copyright © 2013 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eloquent\Constance\Exception;

use Eloquent\Enumeration\Exception\UndefinedMemberExceptionInterface;

/**
 * The interface implemented by undefined constant exceptions.
 */
interface UndefinedConstantExceptionInterface extends
    UndefinedMemberExceptionInterface
{
}
