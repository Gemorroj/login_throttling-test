<?php

declare(strict_types=1);

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginTest extends WebTestCase
{
    public function testLoginThrottling(): void
    {
        $client = static::createClient();

        // reset the login attempts. idk how to reset it manually
        for ($i = 0; $i < 1000; ++$i) {
            $client->jsonRequest('POST', '/login', [
                'username' => 'user',
                'password' => '1234',
            ]);
            $response = $client->getResponse();
            if (200 === $response->getStatusCode()) {
                break;
            }
        }
        if (1000 === $i) {
            self::markTestIncomplete('Cant reset the login attempts');
        }

        // polluting the login attempts
        for ($i = 0; $i < 5; ++$i) {
            $client->jsonRequest('POST', '/login', [
                'username' => 'user',
                'password' => '12345', // incorrect password
            ]);
            $response = $client->getResponse();
            self::assertSame(401, $response->getStatusCode());
            self::assertSame('{"error":"Invalid credentials."}', $response->getContent());
        }

        // wait 5 minutes
        $startTime = microtime(true);
        for ($i = 0; $i < 100; ++$i) {
            $client->jsonRequest('POST', '/login', [
                'username' => 'user',
                'password' => '1234',
            ]);
            $response = $client->getResponse();

            $currentTime = microtime(true);
            $spentTime = round($currentTime - $startTime, 4);

            self::assertSame(401, $response->getStatusCode(), 'Attempts: '.$i.'; Spent: '.$spentTime);
            self::assertSame('{"error":"Too many failed login attempts, please try again in 5 minutes."}', $response->getContent(), 'Attempts: '.$i.'; Spent: '.$spentTime);

            //sleep(1);
        }

        print_r($response->getContent());
    }
}
