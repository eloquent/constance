<?php

/*
 * This file is part of the Constance package.
 *
 * Copyright © 2013 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Eloquent\Constance\AbstractClassConstant;

final class PdoAttribute extends AbstractClassConstant
{
    /**
     * The class to inspect for constants.
     */
    const CONSTANCE_CLASS = 'PDO';

    /**
     * The expression used to match constant names that should be included in
     * this enumeration.
     */
    const CONSTANCE_PATTERN = '{^ATTR_}';
}
