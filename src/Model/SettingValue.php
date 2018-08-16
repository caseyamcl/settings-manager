<?php

namespace SettingsManager\Model;

use SettingsManager\Contract\SettingsProviderInterface;
use SettingsManager\Contract\SettingValueInterface;

/**
 * Class SettingValue
 * @package FSURCC\AccountingSystem\Core\Setting\Model
 */
class SettingValue implements SettingValueInterface
{
    /**
     * @var string
     */
    private $providerName;

    /**
     * @var bool
     */
    private $isMutable;

    /**
     * @var mixed
     */
    private $value;

    /**
     * @var string
     */
    private $settingName;

    /**
     * SettingValue constructor.
     * @param string $settingName
     * @param SettingsProviderInterface $provider
     * @param bool $isMutable
     * @param mixed $value
     */
    public function __construct(
        string $settingName,
        SettingsProviderInterface $provider,
        bool $isMutable,
        $value
    ) {
        $this->providerName = $provider->getName();
        $this->isMutable = $isMutable;
        $this->value = $value;
        $this->settingName = $settingName;
    }

    /**
     * @return string
     */
    public function getSettingName(): string
    {
        return $this->settingName;
    }

    /**
     * @return string
     */
    public function getProviderName(): string
    {
        return $this->providerName;
    }

    /**
     * @return bool
     */
    public function isMutable(): bool
    {
        return $this->isMutable;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }
}
