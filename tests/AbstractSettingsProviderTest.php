<?php

namespace SettingsManager;

use PHPUnit\Framework\TestCase;
use SettingsManager\Contract\SettingProviderInterface;

abstract class AbstractSettingsProviderTest extends TestCase
{
    public function testFindSettingValueReturnsValueWhenFound()
    {

    }

    public function testFindSettingValueReturnsNullWhenNotFound()
    {

    }

    public function testGetSettingValueReturnsValueWhenFound()
    {

    }

    public function testGetSettingValueThrowsExceptionWhenNotFound()
    {

    }

    public function testGetName()
    {

    }

    public function testGetDisplayName()
    {

    }

    public function testGetSettingValuesReturnsIterator()
    {

    }

    /**
     * @return SettingProviderInterface
     */
    abstract protected function getProviderInstance(): SettingProviderInterface;
}
