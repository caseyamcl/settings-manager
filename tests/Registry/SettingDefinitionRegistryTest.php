<?php

namespace SettingsManager\Registry;

use RuntimeException;
use PHPUnit\Framework\TestCase;
use SettingsManager\Fixture\DecimalSetting;
use SettingsManager\Fixture\IntegerSetting;
use SettingsManager\Fixture\StringSetting;

class SettingDefinitionRegistryTest extends TestCase
{
    public function testInstantiateWithValues()
    {
        $registry = new SettingDefinitionRegistry([
            new StringSetting(),
            new DecimalSetting()
        ]);

        $this->assertSame(2, count($registry));
    }

    public function testAdd()
    {
        $registry = new SettingDefinitionRegistry();
        $registry->add(new StringSetting())->add(new IntegerSetting());
        $this->assertSame(2, count($registry));
    }

    public function testHas()
    {
        $registry = new SettingDefinitionRegistry();
        $registry->add(new StringSetting());
        $this->assertTrue($registry->has(StringSetting::NAME));
        $this->assertFalse($registry->has('non_existent'));
    }

    public function testGetReturnsDefinitionWhenExists()
    {
        $registry = new SettingDefinitionRegistry();
        $registry->add(new StringSetting());
        $this->assertInstanceOf(StringSetting::class, $registry->get(StringSetting::NAME));
    }

    public function testGetThrowsExceptionWhenDefinitionDoesNotExist()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage("Setting not found: ");
        $registry = new SettingDefinitionRegistry();
        $registry->get(StringSetting::NAME);
    }

    public function testGetIteratorReturnsReferenceToSameObject()
    {
        $registry = new SettingDefinitionRegistry([
            new StringSetting(),
            new DecimalSetting()
        ]);

        $it1 = $registry->getIterator();
        $it2 = $registry->getIterator();
        $this->assertSame($it1, $it2);
    }
}
