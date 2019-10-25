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

namespace SettingsManager\Fixture;

use SettingsManager\Contract\SettingRepository;
use SettingsManager\Exception\SettingValueNotFoundException;
use SettingsManager\Model\SettingValue;

class TestSettingRepository implements SettingRepository
{
    private $values = [];

    /**
     * @param SettingValue $settingValue
     */
    public function addValue(SettingValue $settingValue)
    {
        $this->values[$settingValue->getName()] = $settingValue->getValue();
    }

    /**
     * Find a setting value by its name
     *
     * @param string $settingName
     * @return mixed|null
     */
    public function findValue(string $settingName)
    {
        return (array_key_exists($settingName, $this->values)) ? $this->values[$settingName] : null;
    }

    /**
     * Get a setting value by its name
     *
     * @param string $settingName
     * @return mixed
     */
    public function getValue(string $settingName)
    {
        if (array_key_exists($settingName, $this->values)) {
            return $this->values[$settingName];
        } else {
            throw SettingValueNotFoundException::fromName($settingName);
        }
    }


    /**
     * List values
     *
     * @return iterable|mixed[]
     */
    public function listValues(): iterable
    {
        return $this->values;
    }
}
