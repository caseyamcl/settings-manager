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
 * Reads settings from multiple providers
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
        $this->providers[] = $provider;
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
        $out = [];

        foreach ($this->providers as $provider) {
            foreach ($provider->getSettingValues() as $value) {
                // If the setting is already in the out array and is immutable, throw exception.
                if (array_key_exists($value->getSettingName(), $out) && ! $value->isMutable()) {
                    throw ImmutableSettingOverrideException::build(
                        $value->getSettingName(),
                        $provider->getName(),
                        $out[$value->getSettingName()]->getProviderName()
                    );
                }

                $out[$value->getSettingName()] = $value;
            }
        }

        return $out ?? [];
    }

    /**
     * @param string $name
     * @return SettingProviderInterface|null
     */
    public function findSettingValue(string $name): ?SettingValueInterface
    {
        return $this->getSettingValues()[$name] ?? null;
    }
}
