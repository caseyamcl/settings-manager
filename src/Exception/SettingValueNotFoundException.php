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

use RuntimeException;
use Throwable;

/**
 * Setting value not found exception
 *
 * Thrown when an implementing library calls `getValue()` or `getSettingValue()` for an undefined value.
 *
 * @author Casey McLaughlin <caseyamcl@gmail.com>
 */
class SettingValueNotFoundException extends RuntimeException implements SettingException
{
    /**
     * Construct instance using setting name
     *
     * @param string $name
     * @param Throwable|null $prior
     * @param int $code
     * @return static
     */
    public static function fromName(string $name, ?Throwable $prior = null, int $code = 0)
    {
        $message = sprintf('Setting value not found: ' . $name);
        return new static($message, $code, $prior);
    }
}
