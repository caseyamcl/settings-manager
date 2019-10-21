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

namespace SettingsManager\Provider;

use SettingsManager\Behavior\SettingProviderTrait;
use SettingsManager\Contract\SettingProviderInterface;
use SettingsManager\Contract\SettingValueInterface;
use SettingsManager\Model\SettingValue;
use SettingsManager\Registry\SettingDefinitionRegistry;

/**
 * Array Settings Provider
 *
 * Reads settings from an array
 *
 * @author Casey McLaughlin <caseyamcl@gmail.com>
 */
class ArraySettingProvider implements SettingProviderInterface
{
    use SettingProviderTrait;

    /**
     * @var array
     */
    private $settings = [];

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $displayName;

    /**
     * ArraySettingProvider constructor.
     *
     * @param array $settings Key/value pairs
     * @param SettingDefinitionRegistry $definitionRegistry
     * @param string $name
     * @param string $displayName
     */
    public function __construct(
        array $settings,
        SettingDefinitionRegistry $definitionRegistry,
        string $name,
        string $displayName
    ) {

        $this->name = $name;
        $this->displayName = $displayName;

        // Validate all of the settings as they are read from the input
        foreach ($settings as $settingName => $value) {
            $mutable = (is_array($value) && isset($value['mutable'])) ? (bool) $value['mutable'] : true;
            $value = (is_array($value) && isset($value['value'])) ? $value['value'] : $value;

            $this->settings[$settingName] = new SettingValue(
                $settingName,
                $this,
                $mutable,
                $definitionRegistry->get($settingName)->processValue($value)
            );
        }
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDisplayName(): string
    {
        return $this->displayName;
    }

    /**
     * Return a key/value set of setting names/values
     *
     * @return iterable|SettingValueInterface[]
     */
    public function getSettingValues(): iterable
    {
        return $this->settings;
    }

    /**
     * @param string $settingName
     * @return SettingProviderInterface|null
     */
    public function findValueInstance(string $settingName): ?SettingValueInterface
    {
        return $this->settings[$settingName] ?? null;
    }
}
