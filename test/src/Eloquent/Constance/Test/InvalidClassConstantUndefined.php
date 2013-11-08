<?php

/*
 * This file is part of the Constance package.
 *
 * Copyright © 2013 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eloquent\Constance\Test;

use Eloquent\Constance\AbstractClassConstant;

class InvalidClassConstantUndefined extends AbstractClassConstant
{
    const CONSTANCE_CLASS = 'NonexistentClass';
}
