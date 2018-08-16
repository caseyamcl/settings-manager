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

namespace SettingsManager\Exception;

use Throwable;

/**
 * Class InvalidSettingValueException
 */
class InvalidSettingValueException extends \RuntimeException
{
    /**
     * @var array|string[]
     */
    private $errors;

    /**
     * InvalidSettingValueException constructor.
     *
     * @param string|array|string[] $messages  One ore more validation error messages
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($messages = "", int $code = 0, Throwable $previous = null)
    {
        $this->errors = (array) $messages;
        parent::__construct(implode(PHP_EOL, $this->errors), $code, $previous);
    }

    /**
     * @return array|string[]
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
