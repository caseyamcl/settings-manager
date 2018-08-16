<?php

namespace SettingsManager\Helper;

use SettingsManager\Contract\SettingInterface;
use FSURCC\AccountingSystem\Core\Util\RequireConstantTrait;

/**
 * Class AbstractSetting
 * @package FSURCC\AccountingSystem\Core\Setting\Helper
 */
abstract class AbstractSetting implements SettingInterface
{
    //use ValidatorSettingTrait;
    use RequireConstantTrait;

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

}
