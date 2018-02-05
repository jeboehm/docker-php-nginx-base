<?php

namespace Tests;

use PHPUnit\Framework\TestCase;

class ExtensionTest extends TestCase
{
    const EXPECTED_EXTENSIONS = [
        'apcu',
        'bcmath',
        'curl',
        'ftp',
        'gd',
        'intl',
        'openssl',
        'PDO',
        'pdo_mysql',
        'pdo_sqlite',
        'redis',
        'zip',
    ];

    /**
     * @dataProvider extensionNameDataProvider
     */
    public function testExpectedModuleIsLoaded(string $extensionName): void
    {
        $this->assertTrue(extension_loaded($extensionName), sprintf('Extension "%s" is loaded', $extensionName));
    }

    public function extensionNameDataProvider(): array
    {
        return array_map(
            function (string $extensionName) {
                return [$extensionName];
            },
            self::EXPECTED_EXTENSIONS
        );
    }
}
