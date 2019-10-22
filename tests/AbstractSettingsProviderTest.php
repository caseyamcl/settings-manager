<?php

/**
 * Settings Manager
 *
 * @license http://opensource.org/licenses/MIT
 * @link https://github.com/caseyamcl/settings-manager
 * @package caseyamcl/settings-manager
 * @author Casey McLaughlin <caseyamcl@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 *  ------------------------------------------------------------------
 */

declare(strict_types=1);

namespace SettingsManager;

use PHPUnit\Framework\TestCase;
use SettingsManager\Contract\SettingProvider;
use SettingsManager\Exception\SettingNameCollisionException;
use SettingsManager\Exception\SettingValueNotFoundException;
use SettingsManager\Fixture\DecimalSetting;
use SettingsManager\Fixture\IntegerSetting;
use SettingsManager\Fixture\StringSetting;
use SettingsManager\Model\AbstractSettingDefinition;
use SettingsManager\Registry\SettingDefinitionRegistry;

abstract class AbstractSettingsProviderTest extends TestCase
{
    public function testFindValueInstanceReturnsValueWhenFound()
    {
        $obj = $this->getProviderInstance();
        $this->assertStringStartsWith('test', $obj->findValueInstance('string_setting')->getValue());
    }

    public function testFindValueInstanceReturnsNullWhenNotFound()
    {
        $obj = $this->getProviderInstance();
        $this->assertNull($obj->findValueInstance('non_existent'));
    }

    public function testFindValueReturnsValueWhenFound()
    {
        $obj = $this->getProviderInstance();
        $this->assertStringStartsWith('test', $obj->findValue('string_setting'));
    }

    public function testFindValueReturnsNullWhenNotFound()
    {
        $obj = $this->getProviderInstance();
        $this->assertNull($obj->findValue('non_existent'));
    }

    public function testGetValueInstanceReturnsValueWhenFound()
    {
        $obj = $this->getProviderInstance();
        $this->assertStringStartsWith('test', $obj->getValueInstance('string_setting')->getValue());
    }

    public function testGetValueInstanceThrowsExceptionWhenNotFound()
    {
        $this->expectException(SettingValueNotFoundException::class);
        $this->getProviderInstance()->getValueInstance('non_existent');
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
     * @return SettingProvider
     */
    abstract protected function getProviderInstance(): SettingProvider;
}
