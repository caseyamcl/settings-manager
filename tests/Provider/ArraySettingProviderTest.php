<?php

namespace SettingsManager\Provider;

use SettingsManager\AbstractSettingsProviderTest;
use SettingsManager\Contract\SettingProviderInterface;

class ArraySettingProviderTest extends AbstractSettingsProviderTest
{
    /**
     * @return SettingProviderInterface
     */
    protected function getProviderInstance(): SettingProviderInterface
    {
        return new ArraySettingProvider(['a' => 'A', 'b' => 1, 'c' => 25.03]);
    }
}
