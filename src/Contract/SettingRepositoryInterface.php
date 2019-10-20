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

namespace SettingsManager\Contract;

/**
 * Setting repository interface defines the interface for storing raw setting values in a persistence layer
 *
 * @package SettingsManager\Contract
 */
interface SettingRepositoryInterface
{
    /**
     * Find a setting value by its name
     *
     * @param string $settingName
     * @return mixed
     */
    public function findValue(string $settingName);

    /**
     * List values
     *
     * @return iterable|mixed[]
     */
    public function listValues(): iterable;
}
