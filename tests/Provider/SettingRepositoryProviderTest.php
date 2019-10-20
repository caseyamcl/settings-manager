<?php

namespace SettingsManager\Provider;

use SettingsManager\AbstractSettingsProviderTest;
use SettingsManager\Contract\SettingProviderInterface;
use SettingsManager\Fixture\TestSettingRepository;

/**
 * Class SettingRepositoryProviderTest
 *
 * @author Casey McLaughlin <caseyamcl@gmail.com>
 */
class SettingRepositoryProviderTest extends AbstractSettingsProviderTest
{
    // LEFT OFF HERE - Refer to the actual implementation in the Saluki repository to see about what to do here...

    /**
     * @return array  Keys are setting names, values are setting values
     */
    protected function getExpectedValues(): array
    {
        // TODO: Implement getExpectedValues() method.
    }

    /**
     * @return SettingProviderInterface
     */
    protected function getProviderInstance(): SettingProviderInterface
    {
        $repo = new TestSettingRepository();
    }
}
