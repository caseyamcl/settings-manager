<?php

declare(strict_types=1);

namespace SettingsManager\Model;

use LogicException;
use PHPUnit\Framework\TestCase;

class AbstractSettingDefinitionTest extends TestCase
{
    public function testIsSensitive()
    {
        $obj = new class extends AbstractSettingDefinition {
            public const SENSITIVE = false;
        };

        $this->assertFalse($obj->isSensitive());
    }

    public function testGetNotes()
    {
        $obj = new class extends AbstractSettingDefinition {
            public const NOTES = 'test';
        };

        $this->assertSame('test', $obj->getNotes());
    }

    public function testGetNameReturnsValueWhenConstantIsSet()
    {
        $obj = new class extends AbstractSettingDefinition {
            public const NAME = 'test';
        };

        $this->assertSame('test', $obj->getName());
    }

    public function testGetNameThrowsExceptionWhenConstantNotSet()
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('must implement constant');

        $obj = new class extends AbstractSettingDefinition {
            // NAME constant purposefully omitted
        };

        $obj->getName();
    }

    public function testGetDefault()
    {
        $obj = new class extends AbstractSettingDefinition {
            public const DEFAULT = 'test';
        };

        $this->assertSame('test', $obj->getDefault());
    }

    public function testGetDisplayNameReturnsValueWhenConstantIsSet()
    {
        $obj = new class extends AbstractSettingDefinition {
            public const DISPLAY_NAME = 'test';
        };

        $this->assertSame('test', $obj->getDisplayName());
    }

    public function testGetDisplayNameThrowsExceptionWhenConstantIsNotSet()
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('must implement constant');

        $obj = new class extends AbstractSettingDefinition {
            // DISPLAY_NAME constant purposefully omitted
        };

        $obj->getDisplayName();
    }

    public function testDefaultImplementationReturnsTheSameValueAsWasPassed()
    {
        $obj = new class extends AbstractSettingDefinition {
            public const NAME = 'test';
            public const DISPLAY_NAME = 'Test setting';
        };
        $this->assertSame('test', $obj->processValue('test'));
    }
}
