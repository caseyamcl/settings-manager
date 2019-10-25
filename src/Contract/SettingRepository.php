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
 * Setting repository interface defines the interface for storing raw setting values in a persistence layer
 *
 * @package SettingsManager\Contract
 */
interface SettingRepository
{
    /**
     * Find a setting value by its name or NULL if it is not found
     *
     * @param string $settingName
     * @return mixed|null
     */
    public function findValue(string $settingName);

    /**
     * Get a setting value by its name or throw an exception if not found
     *
     * @param string $settingName
     * @return mixed
     * @throws SettingValueNotFoundException
     */
    public function getValue(string $settingName);

    /**
     * List values
     *
     * @return iterable|mixed[]
     */
    public function listValues(): iterable;
}
