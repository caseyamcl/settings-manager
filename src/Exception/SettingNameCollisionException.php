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

class SettingNameCollisionException extends LogicException implements SettingException
{
    /**
     * @param string $settingName
     * @return static
     */
    public static function fromName(string $settingName): self
    {
        return new static(sprintf('setting name collision: ' . $settingName));
    }
}
