# uptime-robot

This package wraps another PHP function to create and send a heartbeat for uptime-robot and can log a warning if request was not succesful.

## Upgrade from 1 to 2

there is no `HeartBeatException` anymore. If you want to log that the request to uptime-robot has failed, you need to inject an `\Psr\Log\LoggerInterface` in the constructor.

## Installation

```
composer req pluswerk/uptime-robot
```

## Usage
Send request to UptimeRobot:
```php
$heartBeat = new HeartBeat();
$heartBeat->alive('https://heartbeat.uptimerobot.com/m0000000000-0000000000000000000000000');
```

Throttle your requests with a given time:

```php
$heartBeat->throttledAlive($yourUptimeUrl, 300);
```
