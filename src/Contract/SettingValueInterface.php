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
 * Setting value - Defines the interface for a setting value
 */
interface SettingValueInterface
{
    /**
     * @return string
     */
    public function getSettingName(): string;

    /**
     * @return mixed
     */
    public function getValue();

    /**
     * Get the provider that provided the value for this setting
     *
     * @return string
     */
    public function getProviderName(): string;

    /**
     * Can this value be changed/overridden
     *
     * If the provider that provided this setting set mutable to FALSE, then this will be false.
     *
     * This informs API clients of what is available to be updated dynamically.
     *
     * @return bool
     */
    public function isMutable(): bool;
}
