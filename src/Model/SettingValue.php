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

use SettingsManager\Contract\SettingProvider;

/**
 * Setting value - Stores a value for a given setting
 *
 * @author Casey McLaughlin <caseyamcl@gmail.com>
 */
class SettingValue
{
    /**
     * @var string
     */
    private $providerName;

    /**
     * @var bool
     */
    private $isMutable;

    /**
     * @var mixed
     */
    private $value;

    /**
     * @var string
     */
    private $settingName;

    /**
     * SettingValue constructor.
     * @param string $settingName
     * @param SettingProvider $provider
     * @param bool $isMutable
     * @param mixed $value
     */
    public function __construct(
        string $settingName,
        SettingProvider $provider,
        bool $isMutable,
        $value
    ) {
        $this->providerName = $provider->getName();
        $this->isMutable = $isMutable;
        $this->value = $value;
        $this->settingName = $settingName;
    }

    /**
     * @return string
     */
    final public function getName(): string
    {
        return $this->settingName;
    }

    /**
     * @return string
     */
    final public function getProviderName(): string
    {
        return $this->providerName;
    }

    /**
     * @return bool
     */
    final public function isMutable(): bool
    {
        return $this->isMutable;
    }

    /**
     * @return mixed
     */
    final public function getValue()
    {
        return $this->value;
    }
}
