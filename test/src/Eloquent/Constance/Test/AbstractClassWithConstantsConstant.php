<?php

/*
 * This file is part of the Constance package.
 *
 * Copyright © 2014 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eloquent\Constance\Test;

use Eloquent\Constance\AbstractClassConstant;

abstract class AbstractClassWithConstantsConstant extends AbstractClassConstant
{
    const CONSTANCE_CLASS = 'Eloquent\Constance\Test\ClassWithConstants';
}
