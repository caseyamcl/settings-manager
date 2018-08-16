<?php

namespace SettingsManager\Provider;

use SettingsManager\Contract\SettingRepositoryInterface;
use SettingsManager\Contract\SettingsProviderInterface;
use SettingsManager\Contract\SettingValueInterface;
use SettingsManager\Model\SettingValue;

/**
 * Class DoctrineOrmProvider
 * @package FSURCC\AccountingSystem\Core\Setting\Provider
 */
class SettingRepositoryProvider implements SettingsProviderInterface
{
    /**
     * @var SettingRepositoryInterface
     */
    private $repository;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $description;

    /**
     * DoctrineOrmProvider constructor.
     *
     * @param SettingRepositoryInterface $repository
     * @param string $name
     * @param string $description
     */
    public function __construct(
        SettingRepositoryInterface $repository,
        string $name = 'database',
        string $description = 'Settings stored in database'
    ) {
        $this->repository = $repository;
        $this->name = $name;
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDisplayName(): string
    {
        return $this->description;
    }

    /**
     * Return a key/value set of setting names/values
     *
     * @return iterable|SettingValueInterface[]
     */
    public function getSettingValues(): iterable
    {
        foreach ($this->repository->listValues() as $name => $value) {
            $out[] = new SettingValue($name, $this, true, $value);
        }

        return $out ?? [];
    }

    public function findValue(string $settingName): ?SettingValueInterface
    {
        return ($value = $this->repository->findValue($settingName))
            ? new SettingValue($settingName, $this, true, $value)
            : null;
    }
}
