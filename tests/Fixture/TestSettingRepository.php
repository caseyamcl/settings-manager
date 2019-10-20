<?php

declare(strict_types=1);

namespace SettingsManager\Fixture;

use SettingsManager\Contract\SettingRepositoryInterface;
use SettingsManager\Contract\SettingValueInterface;

class TestSettingRepository implements SettingRepositoryInterface
{
    private $values = [];

    /**
     * @param SettingValueInterface $settingValue
     */
    public function addValue(SettingValueInterface $settingValue)
    {
        $this->values[$settingValue->getName()] = $settingValue->getValue();
    }

    /**
     * Find a setting value by its name
     *
     * @param string $settingName
     * @return mixed|null
     */
    public function findValue(string $settingName)
    {
        return (array_key_exists($settingName, $this->values)) ? $this->values[$settingName] : null;
    }

    /**
     * List values
     *
     * @return iterable|mixed[]
     */
    public function listValues(): iterable
    {
        return $this->values;
    }
}
