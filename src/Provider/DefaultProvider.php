<?php

namespace SettingsManager\Provider;

use SettingsManager\Contract\SettingsProviderInterface;
use SettingsManager\Contract\SettingValueInterface;
use SettingsManager\Model\SettingValue;
use SettingsManager\Registry\SettingDefinitionRegistry;

/**
 * Class DefaultProvider
 * @package FSURCC\AccountingSystem\Core\Setting\Provider
 */
class DefaultProvider implements SettingsProviderInterface
{
    /**
     * @var SettingDefinitionRegistry
     */
    private $registry;

    /**
     * DefaultProvider constructor.
     * @param SettingDefinitionRegistry $registry
     */
    public function __construct(SettingDefinitionRegistry $registry)
    {
        $this->registry = $registry;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'defaults';
    }

    /**
     * @return string
     */
    public function getDisplayName(): string
    {
        return 'Default setting values';
    }

    /**
     * Return a key/value set of setting names/values
     *
     * @return iterable|SettingValueInterface[]
     */
    public function getSettingValues(): iterable
    {
        foreach ($this->registry->getIterator() as $setting) {
            $out[] = new SettingValue($setting->getName(), $this, true, $setting->getDefault());
        }

        return $out ?? [];
    }

    public function findValue(string $settingName): ?SettingValueInterface
    {
        return ($this->getSettingValues()[$settingName]) ?? null;
    }


}
