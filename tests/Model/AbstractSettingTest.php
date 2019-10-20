<?php

namespace SettingsManager\Model;

use LogicException;
use PHPUnit\Framework\TestCase;

class AbstractSettingTest extends TestCase
{
    public function testIsSensitive()
    {
        $obj = new class extends AbstractSettingDefinition {
            public const SENSITIVE = false;

            public function processValue($value)
            {
                return $value;
            }
        };

        $this->assertFalse($obj->isSensitive());
    }

    public function testGetNotes()
    {
        $obj = new class extends AbstractSettingDefinition {
            public const NOTES = 'test';

            public function processValue($value)
            {
                return $value;
            }
        };

        $this->assertSame('test', $obj->getNotes());
    }

    public function testGetNameReturnsValueWhenConstantIsSet()
    {
        $obj = new class extends AbstractSettingDefinition {
            public const NAME = 'test';

            public function processValue($value)
            {
                return $value;
            }
        };

        $this->assertSame('test', $obj->getName());
    }

    public function testGetNameThrowsExceptionWhenConstantNotSet()
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('must implement constant');

        $obj = new class extends AbstractSettingDefinition {
            public function processValue($value)
            {
                return $value;
            }
        };

        $obj->getName();
    }

    public function testGetDefault()
    {
        $obj = new class extends AbstractSettingDefinition {
            const DEFAULT = 'test';

            public function processValue($value)
            {
                return $value;
            }
        };

        $this->assertSame('test', $obj->getDefault());
    }

    public function testGetDisplayNameReturnsValueWhenConstantIsSet()
    {
        $obj = new class extends AbstractSettingDefinition {
            public const DISPLAY_NAME = 'test';

            public function processValue($value)
            {
                return $value;
            }
        };

        $this->assertSame('test', $obj->getDisplayName());
    }

    public function testGetDisplayNameThrowsExceptionWhenConstantIsNotSet()
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('must implement constant');

        $obj = new class extends AbstractSettingDefinition {
            public function processValue($value)
            {
                return $value;
            }
        };

        $obj->getDisplayName();
    }
}
