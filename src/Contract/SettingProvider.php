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

namespace SettingsManager\Contract;

use SettingsManager\Exception\SettingValueNotFoundException;
use SettingsManager\Model\SettingValue;

/**
 * Settings provider interface
 */
interface SettingProvider
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
     * @return iterable|SettingValue[]
     */
    public function getSettingValues(): iterable;

    /**
     * Find a setting instance or return NULL
     *
     * @param string $settingName
     * @return SettingValue|null
     */
    public function findValueInstance(string $settingName): ?SettingValue;

    /**
     * Find a setting value or return NULL
     *
     * @param string $settingName
     * @return mixed
     */
    public function findValue(string $settingName);

    /**
     * Get a setting instance or throw an exception
     *
     * @param string $settingName
     * @return SettingValue
     * @throws SettingValueNotFoundException
     */
    public function getValueInstance(string $settingName): SettingValue;

    /**
     * Get a setting value or throw exception
     *
     * @param string $settingName
     * @return mixed
     * @throws SettingValueNotFoundException
     */
    public function getValue(string $settingName);
}
