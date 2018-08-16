<?php

namespace SettingsManager\Factory;

use FSURCC\AccountingSystem\Core\Configuration\AppConfig;
use SettingsManager\Contract\SettingInterface;
use SettingsManager\Contract\SettingRepositoryInterface;
use SettingsManager\Contract\SettingsProviderInterface;
use SettingsManager\Provider\ArraySettingProvider;
use SettingsManager\Provider\CascadingSettingProvider;
use SettingsManager\Provider\DefaultProvider;
use SettingsManager\Provider\SettingRepositoryProvider;
use SettingsManager\Registry\SettingDefinitionRegistry;
use FSURCC\AccountingSystem\Domain\Setting\SettingRepository;
use Psr\Container\ContainerInterface;
use Symfony\Component\Finder\Finder;

/**
 * Class SettingFactory
 * @package SettingsManager\Factory
 */
class SettingFactory
{
    const SETTING_DIRCTORY  = __DIR__ . '/../../../Setting';
    const SETTING_NAMESPACE = "FSURCC\\AccountingSystem\\Setting";

    /**
     * @param ContainerInterface $container
     * @return SettingDefinitionRegistry
     */
    public function buildSettingRegistry(ContainerInterface $container): SettingDefinitionRegistry
    {
        $registry = new SettingDefinitionRegistry();
        $finder = (new Finder())->in(static::SETTING_DIRCTORY)->name('/\.php$/i');

        foreach ($finder->getIterator() as $file) {

            $className = sprintf(
                "\\%s\\%s",
                trim(static::SETTING_NAMESPACE, "\\"),
                str_replace('/', "\\", basename($file->getRelativePathname(), '.php'))
            );

            if (is_a($className, SettingInterface::class, true)) {
                $registry->add($container->get($className));
            }
        }

        return $registry;
    }

    public function buildSettingsProvider(
        AppConfig $config,
        SettingDefinitionRegistry $registry,
        SettingRepository $settingRepository
    ): SettingsProviderInterface {

        return new CascadingSettingProvider([
            new DefaultProvider($registry),
            new ArraySettingProvider($config->getSettings(), $registry, 'config', 'Configuration file'),
            new SettingRepositoryProvider($settingRepository)
        ]);
    }
}
