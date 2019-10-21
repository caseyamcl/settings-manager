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

use SettingsManager\AbstractSettingsProviderTest;
use SettingsManager\Contract\SettingProviderInterface;
use SettingsManager\Fixture\TestSettingRepository;
use SettingsManager\Model\SettingValue;

/**
 * Class SettingRepositoryProviderTest
 *
 * @author Casey McLaughlin <caseyamcl@gmail.com>
 */
class SettingRepositoryProviderTest extends AbstractSettingsProviderTest
{
    /**
     * @return array  Keys are setting names, values are setting values
     */
    protected function getExpectedValues(): array
    {
        return [
            'string_setting' => 'test',
            'integer_setting' => 20,
            'decimal_setting' => 15.2
        ];
    }

    /**
     * @return SettingProviderInterface
     */
    protected function getProviderInstance(): SettingProviderInterface
    {
        $repo = new TestSettingRepository();
        $provider = new SettingRepositoryProvider($repo);
        $repo->addValue(new SettingValue('string_setting', $provider, true, 'test'));
        $repo->addValue(new SettingValue('integer_setting', $provider, true, 20));
        $repo->addValue(new SettingValue('decimal_setting', $provider, true, 15.2));
        return $provider;
    }
}
