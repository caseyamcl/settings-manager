<?php
/**
 * Settings Manager
 *
 * @license http://opensource.org/licenses/MIT
 * @link https://github.com/caseyamcl/settings_manager
 * @package caseyamcl/settings_manager
 * @author Casey McLaughlin <caseyamcl@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 *  ------------------------------------------------------------------
 */

namespace SettingsManager\Provider;

use SettingsManager\Contract\SettingsProviderInterface;
use SettingsManager\Contract\SettingValueInterface;
use SettingsManager\Model\SettingValue;
use SettingsManager\Registry\SettingDefinitionRegistry;

/**
 * Class DefaultProvider
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

    public function findSettingValue(string $settingName): ?SettingValueInterface
    {
        return ($this->getSettingValues()[$settingName]) ?? null;
    }


    public function findValue(string $settingName)
    {
        if ($setting = $this->findSettingValue($settingName)) {
            return $setting->getValue();
        } else {
            return null;
        }
    }
}
