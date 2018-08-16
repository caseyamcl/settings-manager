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

namespace SettingsManager\Exception;

use SettingsManager\Contract\SettingInterface;

/**
 * Class SettingNameCollisionException
 */
class ImmutableSettingOverrideException extends \LogicException
{
    /**
     * @param string $settingName
     * @param string $provider
     * @param SettingInterface $collidesWith
     * @param \Throwable|null $prior
     * @return ImmutableSettingOverrideException
     */
    public static function build(
        string $settingName,
        string $provider,
        SettingInterface $collidesWith,
        \Throwable $prior = null
    ) {

        $msg = sprintf(
            'Setting name collision: %s (attempting to load from %s; already loaded from %s)',
            $settingName,
            $provider,
            $collidesWith->getName()
        );

        return new static($msg, $prior ? $prior->getCode() : 0, $prior);
    }
}
