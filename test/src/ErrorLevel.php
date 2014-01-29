<?php

/*
 * This file is part of the Constance package.
 *
 * Copyright © 2014 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Eloquent\Constance\AbstractGlobalConstant;

final class ErrorLevel extends AbstractGlobalConstant
{
    /**
     * The expression used to match constant names that should be included in
     * this enumeration.
     */
    const CONSTANCE_PATTERN = '{^E_}';
}
