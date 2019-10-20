<?php

declare(strict_types=1);

namespace SettingsManager\Fixture;

use SettingsManager\Exception\InvalidSettingValueException;
use SettingsManager\Model\AbstractSettingDefinition;

class IntegerSetting extends AbstractSettingDefinition
{
    public const NAME = 'integer_setting';
    public const DISPLAY_NAME = 'Integer Setting';
    public const DEFAULT = 3;

        /**
     * Process, validate, and store a new value
     *
     * @param mixed $value The raw value
     * @return mixed  The processed value to store
     */
    public function processValue($value)
    {
        if (! is_int($value)) {
            throw new InvalidSettingValueException('value must be an integer');
        }
        if ($value >= 20) {
            throw new InvalidSettingValueException('value must be less than 20');
        }

        return $value;
    }
}
