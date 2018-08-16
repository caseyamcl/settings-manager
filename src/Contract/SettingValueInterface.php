<?php

namespace SettingsManager\Contract;

/**
 * Class SettingValue
 * @package FSURCC\AccountingSystem\Core\Setting\Contract
 */
interface SettingValueInterface
{
    /**
     * @return string
     */
    public function getSettingName(): string;

    /**
     * @return mixed
     */
    public function getValue();

    /**
     * Get the provider that provided the value for this setting
     *
     * @return string
     */
    public function getProviderName(): string;

    /**
     * Can this value be changed/overridden
     *
     * If the provider that provided this setting set mutable to FALSE, then this will be false.
     *
     * This informs API clients of what is available to be updated dynamically.
     *
     * @return bool
     */
    public function isMutable(): bool;
}
