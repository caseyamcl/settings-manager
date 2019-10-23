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
 * Class SettingDefinitionNotFoundException
 *
 * @author Casey McLaughlin <caseyamcl@gmail.com>
 */
class SettingDefinitionNotFoundException extends RuntimeException implements SettingException
{
    /**
     * @param string $name
     * @param Throwable|null $previous
     * @return static
     */
    public static function forSetting(string $name, Throwable $previous = null): self
    {
        return new static("Setting definition not found: " . $name, 0, $previous);
    }
}
