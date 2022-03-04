<?php

declare(strict_types=1);

namespace Pluswerk\UptimeRobot;

use Pluswerk\UptimeRobot\Exception\HeartBeatException;

class HeartBeat
{
    /**
     * @param string $url
     * @throws \Pluswerk\UptimeRobot\Exception\HeartBeatException
     */
    public function alive(string $url): void
    {
        $context = stream_context_set_default(
            [
                'http' => [
                    'timeout' => 1,
                ],
            ]
        );
        $headers = @get_headers($url, false, $context);
        if (false === $headers) {
            throw new HeartBeatException('HeartBeat error occurred sending alive');
        }

        foreach ($headers as $header) {
            if ($header === 'HTTP/1.1 200 OK') {
                return;
            }
        }

        throw new HeartBeatException('HeartBeat alive did not receive proper http headers from uptime-robot');
    }
}
