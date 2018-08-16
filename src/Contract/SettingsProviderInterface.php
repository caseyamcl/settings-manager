<?php

namespace SettingsManager\Contract;

/**
 * Class SettingsProviderInterface
 * @package FSURCC\AccountingSystem\Core\Setting\Contract
 */
interface SettingsProviderInterface
{
    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return string
     */
    public function getDisplayName(): string;

    /**
     * Return a key/value set of setting names/values
     *
     * @return iterable|SettingValueInterface[]
     */
    public function getSettingValues(): iterable;

    /**
     * @param string $settingName
     * @return SettingsProviderInterface|null
     */
    public function findValue(string $settingName): ?SettingValueInterface;
}
