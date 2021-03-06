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

namespace SettingsManager\Exception;

use LogicException;
use Throwable;

/**
 * Immutable setting override exception
 *
 * Thrown when an implementing library attempts to set an immutable setting
 * that has already been set.
 *
 * @author Casey McLaughlin <caseyamcl@gmail.com>
 */
class ImmutableSettingOverrideException extends LogicException implements SettingException
{
    /**
     * @param string $settingName
     * @param string $provider
     * @param string $originalProvider
     * @param Throwable|null $prior
     * @return ImmutableSettingOverrideException
     */
    public static function build(
        string $settingName,
        string $provider,
        string $originalProvider,
        Throwable $prior = null
    ) {

        $msg = sprintf(
            'Setting name collision: %s (attempting to load from %s; already loaded from %s)',
            $settingName,
            $provider,
            $originalProvider
        );

        return new static($msg, $prior ? $prior->getCode() : 0, $prior);
    }
}
