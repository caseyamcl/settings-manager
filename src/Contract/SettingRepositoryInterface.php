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

namespace SettingsManager\Contract;

/**
 * Class SettingRepositoryInterface
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
     * @return iterable|mixed[]
     */
    public function listValues(): iterable;

}
