<?php

namespace SettingsManager\Provider;

use SettingsManager\AbstractSettingsProviderTest;
use SettingsManager\Contract\SettingProviderInterface;

/**
 * Class ArraySettingProviderTest
 *
 * @author Casey McLaughlin <caseyamcl@gmail.com>
 */
class ArraySettingProviderTest extends AbstractSettingsProviderTest
{
    protected function getExpectedValues(): array
    {
        return [
            'string_setting'  => 'test',
            'integer_setting' => 5,
            'decimal_setting' => 29.5
        ];
    }

    /**
     * @return SettingProviderInterface
     */
    protected function getProviderInstance(): SettingProviderInterface
    {
        $values = [
            'string_setting'  => 'test',
            'integer_setting' => 5,
            'decimal_setting' => 29.5
        ];

        return new ArraySettingProvider($values, $this->buildDefinitions(), 'test', 'Test');
    }
}
