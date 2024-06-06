<?php

declare(strict_types=1);

namespace Pluswerk\UptimeRobot;

use Psr\Log\LoggerInterface;

class HeartBeat
{
    private int $lastThrottledExecution = 0;

    public function __construct(private ?LoggerInterface $logger = null)
    {
    }

    public function alive(string $url): void
    {
        $context = stream_context_set_default(
            [
                'http' => [
                    'timeout' => 5,
                ],
            ]
        );

        $headers = @get_headers($url, PHP_MAJOR_VERSION >= 8 ? false : 0, $context);
        if (false === $headers) {
            $this->logger?->warning('HeartBeat error occurred sending alive');

            return;
        }

        foreach ($headers as $header) {
            if ($header === 'HTTP/1.1 200 OK') {
                return;
            }
        }

        if ($this->logger) {
            $this->logger->warning('HeartBeat alive did not receive proper http headers from uptime-robot');
        }
    }

    public function throttledAlive(string $url, int $throttleTime): void
    {
        if (time() > $this->lastThrottledExecution + $throttleTime) {
            $this->alive($url);
            $this->lastThrottledExecution = time();
        }
    }
}
