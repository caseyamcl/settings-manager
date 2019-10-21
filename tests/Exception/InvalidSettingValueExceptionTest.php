<?php

namespace SettingsManager\Exception;

use PHPUnit\Framework\TestCase;

class InvalidSettingValueExceptionTest extends TestCase
{
    public function testGetErrorsWithMultipleErrors()
    {
        $errors = ['test message 1', 'test message 2'];
        $exception = new InvalidSettingValueException($errors);
        $this->assertEquals($errors, $exception->getErrors());
    }

    public function testGetErrorsWithSingleError()
    {
        $exception = new InvalidSettingValueException('test message');
        $this->assertIsArray($exception->getErrors());
        $this->assertEquals('test message', $exception->getErrors()[0]);
    }
}
