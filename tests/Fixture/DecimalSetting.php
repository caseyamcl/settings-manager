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

namespace SettingsManager\Fixture;

use SettingsManager\Exception\InvalidSettingValueException;
use SettingsManager\Model\AbstractSettingDefinition;

class DecimalSetting extends AbstractSettingDefinition
{
    public const NAME = 'decimal_setting';
    public const DISPLAY_NAME = 'Decimal Setting';
    public const DEFAULT = 25.3;
    public const SENSITIVE = false;

    /**
     * Process, validate, and store a new value
     *
     * @param mixed $value The raw value
     * @return mixed  The processed value to store
     */
    public function processValue($value)
    {
        if (! is_numeric($value)) {
            throw new InvalidSettingValueException('value must be numeric');
        }
        if ($value >= 30) {
            throw new InvalidSettingValueException('value must be less than 30');
        }

        return $value;
    }
}
