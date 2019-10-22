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

namespace SettingsManager\Registry;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use RuntimeException;
use SettingsManager\Contract\SettingDefinition;
use SettingsManager\Exception\SettingNameCollisionException;

/**
 * Class SettingDefinitionRegistry
 */
class SettingDefinitionRegistry implements IteratorAggregate, Countable
{
    /**
     * @var ArrayIterator|SettingDefinition[]
     */
    private $items;

    /**
     * SettingDefinitionRegistry constructor.
     * @param iterable|SettingDefinition[]|null $items
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
    final public function has(string $name): bool
    {
        return $this->items->offsetExists($name);
    }

    /**
     * @param string $name
     * @return SettingDefinition
     */
    final public function get(string $name): SettingDefinition
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
     * @param SettingDefinition $setting
     * @return SettingDefinitionRegistry
     */
    final public function add(SettingDefinition $setting): self
    {
        if ($this->items->offsetExists($setting->getName()) && $setting !== $this->items[$setting->getName()]) {
            throw SettingNameCollisionException::fromName($setting->getName());
        }

        $this->items[$setting->getName()] = $setting;
        return $this;
    }

    /**
     * @return ArrayIterator|SettingDefinition[]
     */
    public function getIterator(): ArrayIterator
    {
        return $this->items;
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return $this->items->count();
    }
}
