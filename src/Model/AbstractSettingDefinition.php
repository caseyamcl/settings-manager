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

namespace SettingsManager\Model;

use LogicException;
use SettingsManager\Contract\SettingDefinition;

/**
 * Abstract Setting - provides shortcut constants for common setting parameters
 *
 * @author Casey McLaughlin <caseyamcl@gmail.com>
 */
abstract class AbstractSettingDefinition implements SettingDefinition
{
    public const NAME = null;
    public const DISPLAY_NAME = null;
    public const NOTES = '';
    public const DEFAULT = null;
    public const SENSITIVE = true;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->requireConstant('NAME');
    }

    /**
     * @return string
     */
    public function getDisplayName(): string
    {
        return $this->requireConstant('DISPLAY_NAME');
    }

    /**
     * @return string
     */
    public function getNotes(): string
    {
        return static::NOTES;
    }

    /**
     * @return mixed|null
     */
    public function getDefault()
    {
        return static::DEFAULT;
    }

    /**
     * @return bool
     */
    public function isSensitive(): bool
    {
        return (bool) static::SENSITIVE;
    }

    /**
     * @param mixed $value
     * @return mixed
     */
    public function processValue($value)
    {
        return $value;
    }


    /**
     * Require that a constant exists
     *
     * @param string $name
     * @return mixed
     */
    private function requireConstant(string $name)
    {
        if ($constant = constant(get_called_class() . '::' . $name)) {
            return $constant;
        } else {
            $caller = debug_backtrace()[1]['function'] ?? '(?)';
            throw new LogicException(sprintf(
                "%s must implement constant '%s' or method '%s'",
                get_called_class(),
                $name,
                $caller
            ));
        }
    }
}
