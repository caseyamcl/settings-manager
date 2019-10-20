<?php

namespace SettingsManager\Provider;

use SettingsManager\AbstractSettingsProviderTest;
use SettingsManager\Contract\SettingProviderInterface;
use SettingsManager\Exception\ImmutableSettingOverrideException;

/**
 * Class CascadingSettingProviderTest
 *
 * @author Casey McLaughlin <caseyamcl@gmail.com>
 */
class CascadingSettingProviderTest extends AbstractSettingsProviderTest
{
    public function testSettingImmutableSettingThrowsException()
    {
        $msg = 'Setting name collision: integer_setting (attempting to load from test2; already loaded from test)';

        $this->expectException(ImmutableSettingOverrideException::class);
        $this->expectExceptionMessageMatches($msg);
        $this->getProviderInstance()->withProvider(new ArraySettingProvider([
            'integer_setting' => 3
        ], $this->buildDefinitions(), 'test2', 'Test 2'));
    }

    public function testWithProviderReturnsNewInstanceOfObject()
    {
        $original = $this->getProviderInstance();
        $new = $original->withProvider(new ArraySettingProvider([
            'string_setting' => 'test3'
        ], $this->buildDefinitions(), 'test3', 'Test 3'));

        $this->assertNotSame($original, $new);
        $this->assertSame('test3', $new->getValue('string_setting'));
    }

    /**
     * @return array  Keys are setting names, values are setting values
     */
    protected function getExpectedValues(): array
    {
        return [
            'string_setting' => 'test',
            'integer_setting' => 5,
            'decimal_setting' => 25.3
        ];
    }

    /**
     * @return SettingProviderInterface|CascadingSettingProvider
     */
    protected function getProviderInstance(): SettingProviderInterface
    {
        $definitions = $this->buildDefinitions();

        $arrayProvider = new ArraySettingProvider(
            ['integer_setting' => ['value' => 5, 'mutable' => false]],
            $definitions,
            'test',
            'Test'
        );

        return CascadingSettingProvider::build(
            new DefaultValuesProvider($definitions),
            $arrayProvider
        );
    }
}
