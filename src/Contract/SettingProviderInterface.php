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

/**
 * Settings provider interface
 */
interface SettingProviderInterface
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
     * @return iterable|SettingValueInterface[]
     */
    public function getSettingValues(): iterable;

    /**
     * Find a setting instance or return NULL
     *
     * @param string $settingName
     * @return SettingProviderInterface|null
     */
    public function findValueInstance(string $settingName): ?SettingValueInterface;

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
     * @return SettingValueInterface
     * @throws SettingValueNotFoundException
     */
    public function getValueInstance(string $settingName): SettingValueInterface;

    /**
     * Get a setting value or throw exception
     *
     * @param string $settingName
     * @return mixed
     * @throws SettingValueNotFoundException
     */
    public function getValue(string $settingName);
}
