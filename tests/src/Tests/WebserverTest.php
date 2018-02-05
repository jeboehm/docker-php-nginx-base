<?php

namespace Tests;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Process\Process;

class WebserverTest extends TestCase
{
    const WEBSERVER_EXECUTABLE = '/usr/sbin/nginx';
    const SUPERVISOR_EXECUTABLE = '/usr/bin/supervisord';
    const ENTRYPOINT = '/usr/bin/supervisord -c /etc/supervisord.conf';
    const MAX_CONNECT_TRIES = 5;

    public function testWebserverIsInstalled(): void
    {
        $this->assertFileExists(self::WEBSERVER_EXECUTABLE);
        $this->assertFileExists(self::SUPERVISOR_EXECUTABLE);
    }

    /**
     * @depends testWebserverIsInstalled
     */
    public function testWebserverIsAccessible(): void
    {
        $this->runSupervisord();

        for ($i = 0; $i < self::MAX_CONNECT_TRIES; $i++) {
            $fp = @fsockopen('127.0.0.1', 80);

            if (!$fp) {
                sleep(5);
                continue;
            }

            fclose($fp);
            break;
        }

        $client = new Client();
        $result = $client->request('GET', 'http://127.0.0.1/');

        $this->assertEquals(200, $result->getStatusCode());
        $this->assertContains('HELLO WORLD', (string) $result->getBody());
    }

    private function runSupervisord(): void
    {
        $process = new Process(self::ENTRYPOINT);
        $process->start();
    }
}
