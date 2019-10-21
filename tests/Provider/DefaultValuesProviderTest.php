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

class DefaultValuesProviderTest extends AbstractSettingsProviderTest
{
    /**
     * @return array  Keys are setting names, values are setting values
     */
    protected function getExpectedValues(): array
    {
        return [
            'string_setting' => 'test',
            'integer_setting' => 3,
            'decimal_setting' => 25.3
        ];
    }

    /**
     * @return SettingProviderInterface
     */
    protected function getProviderInstance(): SettingProviderInterface
    {
        return new DefaultValuesProvider($this->buildDefinitions());
    }
}
