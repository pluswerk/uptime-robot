# uptime-robot

This package wraps another PHP function to create and send a heartbeat for uptime-robot and can log a warning if request was not succesful.

## Installation

```
composer require pluswerk/uptime-robot
```

## Usage
Send request to UptimeRobot:
```php
$heartBeat = new HeartBeat();
$heartBeat->alive($yourUptimeUrl);
```

Throttle your requests with a given time:

```php
$heartBeat->throttledAlive($yourUptimeUrl, 300);
```
