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
        if (substr('test', 0, 4) !== 'test') {
            throw new InvalidSettingValueException(['value must begin with "test"']);
        }

        return $value;
    }
}
