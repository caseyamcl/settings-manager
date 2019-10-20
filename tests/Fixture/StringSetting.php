<?php

declare(strict_types=1);

namespace SettingsManager\Fixture;

use SettingsManager\Exception\InvalidSettingValueException;
use SettingsManager\Model\AbstractSettingDefinition;

class StringSetting extends AbstractSettingDefinition
{
    public const NAME = 'string_setting';
    public const DISPLAY_NAME = 'String Setting';
    public const DEFAULT = 'test';

    /**
     * Process, validate, and store a new value
     *
     * @param mixed $value The raw value
     * @return mixed  The processed value to store
     */
    public function processValue($value)
    {
        if ($value !== 'test') {
            throw new InvalidSettingValueException(['value must equal "test"']);
        }

        return $value;
    }
}
