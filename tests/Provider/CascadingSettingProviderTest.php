<?php

namespace SettingsManager\Provider;

use SettingsManager\AbstractSettingsProviderTest;
use SettingsManager\Contract\SettingProviderInterface;

/**
 * Class CascadingSettingProviderTest
 *
 * @author Casey McLaughlin <caseyamcl@gmail.com>
 */
class CascadingSettingProviderTest extends AbstractSettingsProviderTest
{
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
     * @return SettingProviderInterface
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
