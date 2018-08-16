<?php
/**
 * Settings Manager
 *
 * @license http://opensource.org/licenses/MIT
 * @link https://github.com/caseyamcl/settings_manager
 * @package caseyamcl/settings_manager
 * @author Casey McLaughlin <caseyamcl@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 *  ------------------------------------------------------------------
 */

namespace SettingsManager\Helper;

use SettingsManager\Contract\SettingInterface;

/**
 * Class AbstractSetting
 */
abstract class AbstractSetting implements SettingInterface
{
    const NAME = null;
    const DISPLAY_NAME = null;
    const NOTES = '';
    const DEFAULT = null;

    public function getName(): string
    {
        return $this->requireConstant('NAME');
    }

    public function getDisplayName(): string
    {
        return $this->requireConstant('DISPLAY_NAME');
    }

    public function getNotes(): string
    {
        return static::NOTES;
    }

    public function getDefault()
    {
        return static::DEFAULT;
    }

    /**
     * @param string $name
     * @return mixed
     */
    private final function requireConstant(string $name)
    {
        if ($constant = constant(get_called_class() . '::' . $name)) {
            return $constant;
        } else {
            $caller = debug_backtrace()[1]['function'] ?? '(?)';
            throw new \LogicException(sprintf(
                "%s must implement constant '%s' or method '%s'".
                $name,
                $caller
            ));
        }
    }

}
