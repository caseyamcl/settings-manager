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
use SettingsManager\Exception\SettingNameCollisionException;

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
     * @param iterable|SettingDefinitionInterface[]|null $items
     */
    public function __construct(?iterable $items = [])
    {
        $this->items = new ArrayIterator([]);

        foreach ($items as $item) {
            $this->add($item);
        }
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
     * Add a setting definition to the registry
     *
     * @param SettingDefinitionInterface $setting
     * @return SettingDefinitionRegistry
     */
    public function add(SettingDefinitionInterface $setting): self
    {
        if ($this->items->offsetExists($setting->getName()) && $setting !== $this->items[$setting->getName()]) {
            throw SettingNameCollisionException::fromName($setting->getName());
        }

        $this->items[$setting->getName()] = $setting;
        return $this;
    }

    /**
     * @return ArrayIterator|SettingDefinitionInterface[]
     */
    public function getIterator(): ArrayIterator
    {
        return $this->items;
    }
}
