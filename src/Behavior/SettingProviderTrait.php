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

declare(strict_types=1);

namespace SettingsManager\Behavior;

use SettingsManager\Contract\SettingValueInterface;
use SettingsManager\Exception\SettingValueNotFoundException;

/**
 * Trait SettingProviderTrait
 *
 * @author Casey McLaughlin <caseyamcl@gmail.com>
 */
trait SettingProviderTrait
{
    /**
     * Get a value for setting or throw exception
     *
     * @param string $settingName
     * @return SettingValueInterface
     */
    public function getValueInstance(string $settingName): SettingValueInterface
    {
        if ($value = $this->findValueInstance($settingName)) {
            return $value;
        } else {
            throw SettingValueNotFoundException::fromName($settingName);
        }
    }

    /**
     * Get a setting value from name or throw exception
     *
     * @param string $settingName
     * @return mixed
     */
    public function getValue(string $settingName)
    {
        return $this->getValueInstance($settingName)->getValue();
    }

    /**
     * Find value for setting
     *
     * @param string $settingName
     * @return mixed|null
     */
    public function findValue(string $settingName)
    {
        if ($setting = $this->findValueInstance($settingName)) {
            return $setting->getValue();
        } else {
            return null;
        }
    }

    /**
     * Find a setting value instance
     *
     * @param string $settingName
     * @return SettingValueInterface|null
     */
    abstract public function findValueInstance(string $settingName): ?SettingValueInterface;
}
