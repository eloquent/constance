<?php

/*
 * This file is part of the Constance package.
 *
 * Copyright © 2013 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class FunctionalTest extends PHPUnit_Framework_TestCase
{
    /**
     * @requires extension pdo
     */
    public function testPdoAttribute()
    {
        $this->expectOutputString("ATTR_ERRMODE\nPDO::ATTR_ERRMODE");

        $attribute = PdoAttribute::memberByValue(PDO::ATTR_ERRMODE);

        echo $attribute->name();          // outputs 'ATTR_ERRMODE'
        echo "\n";
        echo $attribute->qualifiedName(); // outputs 'PDO::ATTR_ERRMODE'
    }

    /**
     * @requires extension pdo
     */
    public function testMyConnection()
    {
        $attribute = PdoAttribute::memberByValue(PDO::ATTR_ERRMODE);

        $connection = new MyConnection;
        $connection->setAttribute(PdoAttribute::ATTR_AUTOCOMMIT(), true);
        $connection->setAttribute(PdoAttribute::ATTR_PERSISTENT(), false);

        $this->assertTrue(true);
    }

    public function testErrorLevel()
    {
        $this->assertSame(E_NOTICE, ErrorLevel::E_NOTICE()->value());
        $this->assertSame(E_WARNING, ErrorLevel::E_WARNING()->value());
        $this->assertSame(E_ERROR, ErrorLevel::E_ERROR()->value());
        $this->assertSame(E_ALL, ErrorLevel::E_ALL()->value());
        $this->assertSame(E_STRICT, ErrorLevel::E_STRICT()->value());
    }

    public function testBitwise()
    {
        $members = ErrorLevel::membersByBitmask(E_ALL);

        $this->assertContains(ErrorLevel::E_NOTICE(), $members);
        $this->assertContains(ErrorLevel::E_WARNING(), $members);
        $this->assertContains(ErrorLevel::E_ERROR(), $members);

        $members = ErrorLevel::membersExcludedByBitmask(E_ALL);

        $this->assertFalse(array_search(ErrorLevel::E_NOTICE(), $members, true));
        $this->assertFalse(array_search(ErrorLevel::E_WARNING(), $members, true));
        $this->assertFalse(array_search(ErrorLevel::E_ERROR(), $members, true));

        $members = array(ErrorLevel::E_NOTICE(), ErrorLevel::E_DEPRECATED());
        $bitmask = ErrorLevel::membersToBitmask($members);

        $this->assertSame(E_NOTICE | E_DEPRECATED, $bitmask);

        $isStrictByDefault = ErrorLevel::E_STRICT()->valueMatchesBitmask(E_ALL);

        $this->assertInternalType('boolean', $isStrictByDefault);
    }
}
