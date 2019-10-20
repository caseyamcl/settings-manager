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

namespace SettingsManager\Registry;

use ArrayIterator;
use IteratorAggregate;
use RuntimeException;
use SettingsManager\Contract\SettingDefinitionInterface;
use SettingsManager\Exception\ImmutableSettingOverrideException;

/**
 * Class SettingDefinitionRegistry
 */
class SettingDefinitionRegistry implements IteratorAggregate
{
    /**
     * @var ArrayIterator|SettingDefinitionInterface[]
     */
    private $items;

    /**
     * SettingDefinitionRegistry constructor.
     */
    public function __construct()
    {
        $this->items = new ArrayIterator([]);
    }

    /**
     * @param string $name
     * @return bool
     */
    public function has(string $name): bool
    {
        return array_key_exists($name, $this->items);
    }

    /**
     * @param string $name
     * @return SettingDefinitionInterface
     */
    public function get(string $name): SettingDefinitionInterface
    {
        if ($this->has($name)) {
            return $this->items[$name];
        } else {
            throw new RuntimeException("Setting not found: " . $name);
        }
    }

    /**
     * @param SettingDefinitionInterface $setting
     */
    public function add(SettingDefinitionInterface $setting)
    {
        if ($this->items->offsetExists($setting->getName()) && $setting !== $this->items[$setting->getName()]) {
            throw new ImmutableSettingOverrideException('Setting name collision: ' . $setting->getName());
        }

        $this->items[$setting->getName()] = $setting;
    }

    /**
     * @return ArrayIterator|SettingDefinitionInterface[]
     */
    public function getIterator(): ArrayIterator
    {
        return $this->items;
    }
}
