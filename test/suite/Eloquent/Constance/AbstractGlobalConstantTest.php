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

use Eloquent\Constance\Test\ErrorLevel;
use Eloquent\Constance\Test\GlobalConstant;
use Eloquent\Constance\Test\InvalidErrorLevelExtendsConcrete;
use PHPUnit_Framework_TestCase;

/**
 * @covers \Eloquent\Constance\AbstractGlobalConstant
 * @covers \Eloquent\Constance\AbstractConstant
 * @covers \Eloquent\Constance\Exception\UndefinedGlobalConstantException
 */
class AbstractGlobalConstantTest extends PHPUnit_Framework_TestCase
{
    public function testErrorLevel()
    {
        $this->assertSame(E_ERROR, ErrorLevel::E_ERROR()->value());
        $this->assertSame(E_WARNING, ErrorLevel::E_WARNING()->value());
        $this->assertSame(E_NOTICE, ErrorLevel::E_NOTICE()->value());
        $this->assertSame(E_DEPRECATED, ErrorLevel::E_DEPRECATED()->value());
        $this->assertSame(E_ALL, ErrorLevel::E_ALL()->value());
        $this->assertSame(E_STRICT, ErrorLevel::E_STRICT()->value());

        $this->assertSame(ErrorLevel::E_STRICT(), ErrorLevel::memberByValue(E_STRICT));

        $this->assertSame('E_STRICT', ErrorLevel::E_STRICT()->name());
        $this->assertSame('E_STRICT', ErrorLevel::E_STRICT()->qualifiedName());
        $this->assertSame('E_STRICT', strval(ErrorLevel::E_STRICT()));
    }

    public function testClassConstantFailureUndefinedMember()
    {
        $this->setExpectedException(
            __NAMESPACE__ . '\Exception\UndefinedGlobalConstantException',
            "No global constant with name equal to 'NONEXISTANT' is defined in class " .
                "'Eloquent\\\\Constance\\\\Test\\\\ErrorLevel'."
        );
        ErrorLevel::NONEXISTANT();
    }

    public function testClassConstantFailureExtendsConcrete()
    {
        $this->setExpectedException('Eloquent\Enumeration\Exception\ExtendsConcreteException');
        InvalidErrorLevelExtendsConcrete::members();
    }

    public function testNameByValueFailure()
    {
        $this->setExpectedException(__NAMESPACE__ . '\Exception\UndefinedGlobalConstantException');
        ErrorLevel::nameByValue('foo');
    }

    public function testGlobalConstantUnfiltered()
    {
        $this->assertTrue(GlobalConstant::TRUE()->value());
    }
}
