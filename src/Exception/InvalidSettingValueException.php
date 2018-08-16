<?php

namespace SettingsManager\Exception;

use Throwable;

/**
 * Class InvalidSettingValueException
 * @package FSURCC\AccountingSystem\Core\Setting\Exception
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
