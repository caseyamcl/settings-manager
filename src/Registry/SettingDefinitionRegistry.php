<?php

namespace SettingsManager\Registry;

use FSURCC\AccountingSystem\Core\Container\Contract\RegistryInterface;
use SettingsManager\Contract\SettingInterface;
use SettingsManager\Exception\ImmutableSettingOverrideException;

/**
 * Class SettingDefinitionRegistry
 * @package FSURCC\AccountingSystem\Core\Setting\Registry
 */
class SettingDefinitionRegistry implements \IteratorAggregate, RegistryInterface
{
    /**
     * @var \ArrayIterator|SettingInterface[]
     */
    private $items;

    /**
     * SettingDefinitionRegistry constructor.
     */
    public function __construct()
    {
        $this->items = new \ArrayIterator([]);
    }

    /**
     * @param string $name
     * @return bool
     */
    public function has(string $name): bool
    {
        return array_key_exists($name, $this->items);
    }

    /**
     * @param string $name
     * @return SettingInterface
     */
    public function get(string $name): SettingInterface
    {
        if ($this->has($name)) {
            return $this->items[$name];
        } else {
            throw new \RuntimeException("Setting not found: " . $name);
        }
    }

    /**
     * @param SettingInterface $setting
     */
    public function add(SettingInterface $setting)
    {
        if ($this->items->offsetExists($setting->getName()) && $setting !== $this->items[$setting->getName()]) {
            throw new ImmutableSettingOverrideException('Setting name collision: ' . $setting->getName());
        }

        $this->items[$setting->getName()] = $setting;
    }

    /**
     * @return \ArrayIterator|SettingInterface[]
     */
    public function getIterator(): \ArrayIterator
    {
        return $this->items;
    }

    /**
     * @param SettingInterface $item
     */
    public function addItem($item): void
    {
        $this->add($item);
    }
}
