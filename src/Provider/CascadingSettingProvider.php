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

namespace SettingsManager\Provider;

use SettingsManager\Behavior\SettingProviderTrait;
use SettingsManager\Contract\SettingProviderInterface;
use SettingsManager\Contract\SettingValueInterface;
use SettingsManager\Exception\ImmutableSettingOverrideException;

/**
 * Cascading setting provider
 *
 * Reads settings from multiple providers.  This is an immutable object, but it is clone-able (via the `with()` method)
 *
 * @author Casey McLaughlin <caseyamcl@gmail.com>
 */
class CascadingSettingProvider implements SettingProviderInterface
{
    use SettingProviderTrait;

    /**
     * @var array|SettingProviderInterface[]
     */
    private $providers;

    /**
     * @var array|SettingValueInterface[]
     */
    private $valuesCache = [];

    /**
     * Alternate constructor
     *
     * @param SettingProviderInterface[] $provider
     * @return CascadingSettingProvider
     */
    public static function build(SettingProviderInterface ...$provider): self
    {
        return new static($provider);
    }

    /**
     * CascadeProvider constructor.
     * @param iterable $providers
     */
    public function __construct(iterable $providers)
    {
        foreach ($providers as $provider) {
            $this->add($provider);
        }
    }

    private function add(SettingProviderInterface $provider)
    {
        $this->providers[$provider->getName()] = $provider;

        // Initialize setting values
        foreach ($provider->getSettingValues() as $value) {
            $valueCollision = array_key_exists($value->getSettingName(), $this->valuesCache)
                && (! $this->valuesCache[$value->getSettingName()]->isMutable());

            // If the setting is already in the out array and is immutable, throw exception.
            if ($valueCollision) {
                throw ImmutableSettingOverrideException::build(
                    $value->getSettingName(),
                    $provider->getName(),
                    $this->valuesCache[$value->getSettingName()]->getProviderName()
                );
            }

            $this->valuesCache[$value->getSettingName()] = $value;
        }
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'cascade';
    }

    /**
     * @return string
     */
    public function getDisplayName(): string
    {
        return 'Cascading provider interface';
    }

    /**
     * Return a key/value set of setting names/values
     *
     * @return iterable|SettingValueInterface[]
     */
    public function getSettingValues(): iterable
    {
        return $this->valuesCache;
    }

    /**
     * @param string $name
     * @return SettingProviderInterface|null
     */
    public function findValueInstance(string $name): ?SettingValueInterface
    {
        return $this->getSettingValues()[$name] ?? null;
    }

    /**
     * Clone this, adding a provider to the cloned instance
     *
     * @param SettingProviderInterface $provider
     * @return $this
     */
    public function withProvider(SettingProviderInterface $provider): self
    {
        $that = clone $this;
        $that->add($provider);
        return $that;
    }
}
