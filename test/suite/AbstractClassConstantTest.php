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

use Eloquent\Constance\Test\ClassConstant;
use Eloquent\Constance\Test\FilteredClassConstant;
use Eloquent\Constance\Test\InvalidClassConstantExtendsConcrete;
use Eloquent\Constance\Test\InvalidClassConstantUndefined;
use PHPUnit_Framework_TestCase;

/**
 * @covers \Eloquent\Constance\AbstractClassConstant
 * @covers \Eloquent\Constance\AbstractConstant
 * @covers \Eloquent\Constance\Exception\UndefinedClassConstantException
 */
class AbstractClassConstantTest extends PHPUnit_Framework_TestCase
{
    public function testClassConstant()
    {
        $this->assertSame(
            array(
                'STRING_FOO' => ClassConstant::STRING_FOO(),
                'STRING_BAR' => ClassConstant::STRING_BAR(),
                'STRING_BAZ' => ClassConstant::STRING_BAZ(),

                'INT_1' => ClassConstant::INT_1(),
                'INT_2' => ClassConstant::INT_2(),
                'INT_3' => ClassConstant::INT_3(),
                'INT_4' => ClassConstant::INT_4(),
                'INT_5' => ClassConstant::INT_5(),
                'INT_6' => ClassConstant::INT_6(),
                'INT_7' => ClassConstant::INT_7(),
            ),
            ClassConstant::members()
        );

        $this->assertSame('STRING_FOO', ClassConstant::memberByValue('foo')->name());

        $this->assertSame('foo', ClassConstant::STRING_FOO()->value());
        $this->assertSame('STRING_FOO', ClassConstant::STRING_FOO()->name());
        $this->assertSame(
            'Eloquent\Constance\Test\ClassWithConstants::STRING_FOO',
            ClassConstant::STRING_FOO()->qualifiedName()
        );
        $this->assertSame(
            'Eloquent\Constance\Test\ClassWithConstants::STRING_FOO',
            strval(ClassConstant::STRING_FOO())
        );
        $this->assertSame('Eloquent\Constance\Test\ClassWithConstants', ClassConstant::STRING_FOO()->className());
    }

    public function testClassFilteredConstant()
    {
        $this->assertSame(
            array(
                'INT_1' => FilteredClassConstant::INT_1(),
                'INT_2' => FilteredClassConstant::INT_2(),
                'INT_3' => FilteredClassConstant::INT_3(),
                'INT_4' => FilteredClassConstant::INT_4(),
                'INT_5' => FilteredClassConstant::INT_5(),
                'INT_6' => FilteredClassConstant::INT_6(),
                'INT_7' => FilteredClassConstant::INT_7(),
            ),
            FilteredClassConstant::members()
        );
    }

    public function testMembersByBitmask()
    {
        $this->assertSame(
            array(
                'INT_1' => FilteredClassConstant::INT_1(), // 001
                'INT_2' => FilteredClassConstant::INT_2(), // 010
                'INT_3' => FilteredClassConstant::INT_3(), // 011
                'INT_4' => FilteredClassConstant::INT_4(), // 100
                'INT_5' => FilteredClassConstant::INT_5(), // 101
                'INT_6' => FilteredClassConstant::INT_6(), // 110
                'INT_7' => FilteredClassConstant::INT_7(), // 111
            ),
            FilteredClassConstant::membersByBitmask(7)     // 111
        );
        $this->assertSame(
            array(
                'INT_2' => FilteredClassConstant::INT_2(), // 010
                'INT_4' => FilteredClassConstant::INT_4(), // 100
                'INT_6' => FilteredClassConstant::INT_6(), // 110
            ),
            FilteredClassConstant::membersByBitmask(6)     // 110
        );
        $this->assertSame(
            array(
                'INT_1' => FilteredClassConstant::INT_1(), // 001
                'INT_4' => FilteredClassConstant::INT_4(), // 100
                'INT_5' => FilteredClassConstant::INT_5(), // 101
            ),
            FilteredClassConstant::membersByBitmask(5)     // 101
        );
        $this->assertSame(
            array(
                'INT_4' => FilteredClassConstant::INT_4(), // 100
            ),
            FilteredClassConstant::membersByBitmask(4)     // 100
        );
        $this->assertSame(
            array(
                'INT_1' => FilteredClassConstant::INT_1(), // 001
                'INT_2' => FilteredClassConstant::INT_2(), // 010
                'INT_3' => FilteredClassConstant::INT_3(), // 011
            ),
            FilteredClassConstant::membersByBitmask(3)     // 011
        );
        $this->assertSame(
            array(
                'INT_2' => FilteredClassConstant::INT_2(), // 010
            ),
            FilteredClassConstant::membersByBitmask(2)     // 010
        );
        $this->assertSame(
            array(
                'INT_1' => FilteredClassConstant::INT_1(), // 001
            ),
            FilteredClassConstant::membersByBitmask(1)     // 001
        );
    }

    public function testMembersByBitmaskFailureNonInteger()
    {
        $this->setExpectedException(__NAMESPACE__ . '\Exception\NonIntegerValueException');
        ClassConstant::STRING_FOO()->membersByBitmask(1);
    }

    public function testMembersExcludedByBitmask()
    {
        $this->assertSame(
            array(
            ),
            FilteredClassConstant::membersExcludedByBitmask(7) // 111
        );
        $this->assertSame(
            array(
                'INT_1' => FilteredClassConstant::INT_1(),     // 001
                'INT_3' => FilteredClassConstant::INT_3(),     // 011
                'INT_5' => FilteredClassConstant::INT_5(),     // 101
                'INT_7' => FilteredClassConstant::INT_7(),     // 111
            ),
            FilteredClassConstant::membersExcludedByBitmask(6) // 110
        );
        $this->assertSame(
            array(
                'INT_2' => FilteredClassConstant::INT_2(),     // 010
                'INT_3' => FilteredClassConstant::INT_3(),     // 011
                'INT_6' => FilteredClassConstant::INT_6(),     // 110
                'INT_7' => FilteredClassConstant::INT_7(),     // 111
            ),
            FilteredClassConstant::membersExcludedByBitmask(5) // 101
        );
        $this->assertSame(
            array(
                'INT_1' => FilteredClassConstant::INT_1(),     // 001
                'INT_2' => FilteredClassConstant::INT_2(),     // 010
                'INT_3' => FilteredClassConstant::INT_3(),     // 011
                'INT_5' => FilteredClassConstant::INT_5(),     // 101
                'INT_6' => FilteredClassConstant::INT_6(),     // 110
                'INT_7' => FilteredClassConstant::INT_7(),     // 111
            ),
            FilteredClassConstant::membersExcludedByBitmask(4) // 100
        );
        $this->assertSame(
            array(
                'INT_4' => FilteredClassConstant::INT_4(),     // 100
                'INT_5' => FilteredClassConstant::INT_5(),     // 101
                'INT_6' => FilteredClassConstant::INT_6(),     // 110
                'INT_7' => FilteredClassConstant::INT_7(),     // 111
            ),
            FilteredClassConstant::membersExcludedByBitmask(3) // 011
        );
        $this->assertSame(
            array(
                'INT_1' => FilteredClassConstant::INT_1(),     // 001
                'INT_3' => FilteredClassConstant::INT_3(),     // 011
                'INT_4' => FilteredClassConstant::INT_4(),     // 100
                'INT_5' => FilteredClassConstant::INT_5(),     // 101
                'INT_6' => FilteredClassConstant::INT_6(),     // 110
                'INT_7' => FilteredClassConstant::INT_7(),     // 111
            ),
            FilteredClassConstant::membersExcludedByBitmask(2) // 010
        );
        $this->assertSame(
            array(
                'INT_2' => FilteredClassConstant::INT_2(),     // 010
                'INT_3' => FilteredClassConstant::INT_3(),     // 011
                'INT_4' => FilteredClassConstant::INT_4(),     // 100
                'INT_5' => FilteredClassConstant::INT_5(),     // 101
                'INT_6' => FilteredClassConstant::INT_6(),     // 110
                'INT_7' => FilteredClassConstant::INT_7(),     // 111
            ),
            FilteredClassConstant::membersExcludedByBitmask(1) // 001
        );
    }

    public function testMembersExcludedByBitmaskFailureNonInteger()
    {
        $this->setExpectedException(__NAMESPACE__ . '\Exception\NonIntegerValueException');
        ClassConstant::STRING_FOO()->membersExcludedByBitmask(1);
    }

    public function testValueMatchesBitmask()
    {
        $this->assertTrue(FilteredClassConstant::INT_1()->valueMatchesBitmask(3));
        $this->assertTrue(FilteredClassConstant::INT_2()->valueMatchesBitmask(3));
        $this->assertTrue(FilteredClassConstant::INT_3()->valueMatchesBitmask(3));
        $this->assertFalse(FilteredClassConstant::INT_4()->valueMatchesBitmask(3));
    }

    public function testValueMatchesBitmaskFailureNonInteger()
    {
        $this->setExpectedException(__NAMESPACE__ . '\Exception\NonIntegerValueException');
        ClassConstant::STRING_FOO()->valueMatchesBitmask(1);
    }

    public function testMembersToBitMask()
    {
        $this->assertSame(
            7,
            FilteredClassConstant::membersToBitmask(
                array(
                    FilteredClassConstant::INT_1(),
                    FilteredClassConstant::INT_2(),
                    FilteredClassConstant::INT_4(),
                )
            )
        );
        $this->assertSame(
            6,
            FilteredClassConstant::membersToBitmask(
                array(
                    FilteredClassConstant::INT_2(),
                    FilteredClassConstant::INT_4(),
                )
            )
        );
        $this->assertSame(
            5,
            FilteredClassConstant::membersToBitmask(
                array(
                    FilteredClassConstant::INT_1(),
                    FilteredClassConstant::INT_4(),
                )
            )
        );
        $this->assertSame(
            4,
            FilteredClassConstant::membersToBitmask(
                array(
                    FilteredClassConstant::INT_4(),
                )
            )
        );
        $this->assertSame(
            3,
            FilteredClassConstant::membersToBitmask(
                array(
                    FilteredClassConstant::INT_1(),
                    FilteredClassConstant::INT_2(),
                )
            )
        );
        $this->assertSame(
            2,
            FilteredClassConstant::membersToBitmask(
                array(
                    FilteredClassConstant::INT_2(),
                )
            )
        );
        $this->assertSame(
            1,
            FilteredClassConstant::membersToBitmask(
                array(
                    FilteredClassConstant::INT_1(),
                )
            )
        );
    }

    public function testMembersToBitmaskFailureNonInteger()
    {
        $this->setExpectedException(__NAMESPACE__ . '\Exception\NonIntegerValueException');
        ClassConstant::membersToBitmask(array(ClassConstant::STRING_FOO()));
    }

    public function testClassConstantFailureUndefinedMember()
    {
        $this->setExpectedException(
            __NAMESPACE__ . '\Exception\UndefinedClassConstantException',
            "No constant with name equal to 'NONEXISTANT' is defined in class " .
                "'Eloquent\\\\Constance\\\\Test\\\\ClassConstant'."
        );
        ClassConstant::NONEXISTANT();
    }

    public function testClassConstantFailureUndefinedClass()
    {
        $this->setExpectedException(__NAMESPACE__ . '\Exception\UndefinedClassException');
        InvalidClassConstantUndefined::members();
    }

    public function testClassConstantFailureExtendsConcrete()
    {
        $this->setExpectedException('Eloquent\Enumeration\Exception\ExtendsConcreteException');
        InvalidClassConstantExtendsConcrete::members();
    }

    public function testNameByValueFailure()
    {
        $this->setExpectedException(__NAMESPACE__ . '\Exception\UndefinedClassConstantException');
        ClassConstant::nameByValue('qux');
    }
}
