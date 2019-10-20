<?php

namespace SettingsManager;

use PHPUnit\Framework\TestCase;
use SettingsManager\Contract\SettingProviderInterface;
use SettingsManager\Exception\SettingNameCollisionException;
use SettingsManager\Exception\SettingValueNotFoundException;
use SettingsManager\Fixture\DecimalSetting;
use SettingsManager\Fixture\IntegerSetting;
use SettingsManager\Fixture\StringSetting;
use SettingsManager\Model\AbstractSettingDefinition;
use SettingsManager\Registry\SettingDefinitionRegistry;

abstract class AbstractSettingsProviderTest extends TestCase
{
    public function testFindSettingValueReturnsValueWhenFound()
    {
        $obj = $this->getProviderInstance();
        $this->assertSame('test', $obj->findSettingValue('string_setting')->getValue());
    }

    public function testFindSettingValueReturnsNullWhenNotFound()
    {
        $obj = $this->getProviderInstance();
        $this->assertNull($obj->findSettingValue('non_existent'));
    }

    public function testGetSettingValueReturnsValueWhenFound()
    {
        $obj = $this->getProviderInstance();
        $this->assertSame('test', $obj->getSettingValue('string_setting')->getValue());
    }

    public function testGetSettingValueThrowsExceptionWhenNotFound()
    {
        $this->expectException(SettingValueNotFoundException::class);
        $this->getProviderInstance()->getSettingValue('non_existent');
    }

    public function testGetName()
    {
        $this->assertNotEmpty($this->getProviderInstance()->getName());
        $this->assertIsString($this->getProviderInstance()->getName());
    }

    public function testGetDisplayName()
    {
        $this->assertNotEmpty($this->getProviderInstance()->getDisplayName());
        $this->assertIsString($this->getProviderInstance()->getDisplayName());
    }

    public function testGetSettingValuesReturnsIterator()
    {
        $this->assertIsIterable($this->getProviderInstance()->getSettingValues());
    }

    public function testAttemptToAddMultipleSettingDefinitionsWithTheSameNameThrowsException()
    {
        $this->expectException(SettingNameCollisionException::class);
        $this->expectExceptionMessage('setting name collision');

        $settingDef = new class extends AbstractSettingDefinition {
            public const NAME = 'string_setting';

            public function processValue($value)
            {
                return $value;
            }
        };

        $definitions = $this->buildDefinitions();
        $definitions->add($settingDef);
    }

    /**
     * @dataProvider valuesDataProvider
     * @param $expectedValue
     * @param $actualValue
     */
    public function testGetValuesReturnExpectedValues($expectedValue, $actualValue)
    {
        $this->assertEquals($expectedValue, $actualValue);
    }

    /**
     * @return \Generator
     */
    public function valuesDataProvider()
    {
        foreach ($this->getExpectedValues() as $settingName => $settingValue) {
            yield [$settingValue, $this->getProviderInstance()->getValue($settingName)];
        }
    }

    /**
     * @return SettingDefinitionRegistry
     */
    protected function buildDefinitions(): SettingDefinitionRegistry
    {
        $definitions = new SettingDefinitionRegistry();
        $definitions->add(new DecimalSetting());
        $definitions->add(new StringSetting());
        $definitions->add(new IntegerSetting());
        return $definitions;
    }

    /**
     * @return array  Keys are setting names, values are setting values
     */
    abstract protected function getExpectedValues(): array;


    /**
     * @return SettingProviderInterface
     */
    abstract protected function getProviderInstance(): SettingProviderInterface;
}
