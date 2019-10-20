<?php

/**
 * Settings Manager
 *
 * @license http://opensource.org/licenses/MIT
 * @link https://github.com/caseyamcl/settings-manager
 * @package caseyamcl/settings-manager
 * @author Casey McLaughlin <caseyamcl@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 *  ------------------------------------------------------------------
 */

namespace SettingsManager\Provider;

use SettingsManager\Behavior\SettingProviderTrait;
use SettingsManager\Contract\SettingProviderInterface;
use SettingsManager\Contract\SettingValueInterface;
use SettingsManager\Model\SettingValue;
use SettingsManager\Registry\SettingDefinitionRegistry;

/**
 * Defaults Provider
 *
 * Reads default values
 *
 * @author Casey McLaughlin <caseyamcl@gmail.com>
 */
class DefaultValuesProvider implements SettingProviderInterface
{
    use SettingProviderTrait;

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
            $out[$setting->getName()] = new SettingValue($setting->getName(), $this, true, $setting->getDefault());
        }

        return $out ?? [];
    }

    public function findValueInstance(string $settingName): ?SettingValueInterface
    {
        return ($this->getSettingValues()[$settingName]) ?? null;
    }
}
