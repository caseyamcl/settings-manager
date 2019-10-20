<?php

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
