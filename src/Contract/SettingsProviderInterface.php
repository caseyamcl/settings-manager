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
 * Class SettingsProviderInterface
 */
interface SettingsProviderInterface
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
     * @return SettingsProviderInterface|null
     */
    public function findSettingValue(string $settingName): ?SettingValueInterface;

    /**
     * Find a setting value or return NULL
     *
     * @param string $settingName
     * @return mixed|null
     */
    public function findValue(string $settingName);
}
