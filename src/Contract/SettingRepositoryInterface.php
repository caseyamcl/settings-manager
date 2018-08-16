<?php

namespace SettingsManager\Contract;

/**
 * Class SettingRepositoryInterface
 * @package SettingsManager\Contract
 */
interface SettingRepositoryInterface
{
    /**
     * Find a setting value by its name
     *
     * @param string $settingName
     * @return mixed
     */
    public function findValue(string $settingName);

    /**
     * @return iterable|mixed[]
     */
    public function listValues(): iterable;

}
