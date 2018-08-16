<?php

namespace SettingsManager\Contract;

/**
 * Class SettingInterface
 * @package FSURCC\AccountingSystem\Core\Setting\Contract
 */
interface SettingInterface
{
    /**
     * The canonical name for this setting (machine-friendly)
     * @return string
     */
    public function getName(): string;

    /**
     * Get a human-friendly display name for this setting
     * @return string
     */
    public function getDisplayName(): string;

    /**
     * Get notes/documentation for this setting
     *
     * @return string
     */
    public function getNotes(): string;

    /**
     * Return the default value for this setting
     *
     * If no default, return NULL
     *
     * @return mixed
     */
    public function getDefault();

    /**
     * Process, validate, and store a new value
     *
     * @param mixed $value  The raw value
     * @return mixed  The processed value to store
     */
    public function processValue($value);
}
