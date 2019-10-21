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
