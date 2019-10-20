<?php

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
class SettingValueNotFoundException extends RuntimeException
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
