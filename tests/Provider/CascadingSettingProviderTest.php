<?php

namespace SettingsManager\Provider;

use SettingsManager\AbstractSettingsProviderTest;
use SettingsManager\Contract\SettingProviderInterface;
use SettingsManager\Exception\ImmutableSettingOverrideException;

/**
 * Class CascadingSettingProviderTest
 *
 * @author Casey McLaughlin <caseyamcl@gmail.com>
 */
class CascadingSettingProviderTest extends AbstractSettingsProviderTest
{
    public function testSettingImmutableSettingThrowsException()
    {
        $this->expectException(ImmutableSettingOverrideException::class);
        $this->expectExceptionMessage('Setting name collision: integer_setting (attempting to load from test2; already loaded from test)');
        $this->getProviderInstance()->withProvider(new ArraySettingProvider([
            'integer_setting' => 3
        ], $this->buildDefinitions(), 'test2', 'Test 2'));
    }

    /**
     * @return array  Keys are setting names, values are setting values
     */
    protected function getExpectedValues(): array
    {
        return [
            'string_setting' => 'test',
            'integer_setting' => 5,
            'decimal_setting' => 25.3
        ];
    }

    /**
     * @return SettingProviderInterface|CascadingSettingProvider
     */
    protected function getProviderInstance(): SettingProviderInterface
    {
        $definitions = $this->buildDefinitions();

        $arrayProvider = new ArraySettingProvider(
            ['integer_setting' => ['value' => 5, 'mutable' => false]],
            $definitions,
            'test',
            'Test'
        );

        return CascadingSettingProvider::build(
            new DefaultValuesProvider($definitions),
            $arrayProvider
        );
    }
}
