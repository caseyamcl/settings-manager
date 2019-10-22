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
use SettingsManager\Contract\SettingRepository;
use SettingsManager\Contract\SettingProvider;
use SettingsManager\Model\SettingValue;

/**
 * Settings Repository provider
 *
 * Reads settings from an instance that implements the `Contract\SettingRepositoryInterface`
 *
 * @author Casey McLaughlin <caseyamcl@gmail.com>
 */
class SettingRepositoryProvider implements SettingProvider
{
    use SettingProviderTrait;

    /**
     * @var SettingRepository
     */
    private $repository;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $description;

    /**
     * DoctrineOrmProvider constructor.
     *
     * @param SettingRepository $repository
     * @param string $name
     * @param string $description
     */
    public function __construct(
        SettingRepository $repository,
        string $name = 'database',
        string $description = 'Settings stored in database'
    ) {
        $this->repository = $repository;
        $this->name = $name;
        $this->description = $description;
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
        return $this->description;
    }

    /**
     * Return a key/value set of setting names/values
     *
     * @return iterable|SettingValue[]
     */
    public function getSettingValues(): iterable
    {
        foreach ($this->repository->listValues() as $name => $value) {
            $out[] = new SettingValue($name, $this, true, $value);
        }

        return $out ?? [];
    }

    public function findValueInstance(string $settingName): ?SettingValue
    {
        return ($value = $this->repository->findValue($settingName))
            ? new SettingValue($settingName, $this, true, $value)
            : null;
    }
}
