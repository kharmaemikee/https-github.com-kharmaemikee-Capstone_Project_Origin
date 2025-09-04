<?php

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\TrustProxies as Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\IpUtils;

class TrustProxies extends Middleware
{
    /**
     * The trusted proxies for this application.
     *
     * @var array<int, string>|string|null
     */
    protected $proxies;

    /**
     * The headers that should be used to detect proxies.
     *
     * @var int
     */
    protected $headers =
        Request::HEADER_X_FORWARDED_FOR |
        Request::HEADER_X_FORWARDED_HOST |
        Request::HEADER_X_FORWARDED_PORT |
        Request::HEADER_X_FORWARDED_PROTO |
        Request::HEADER_X_FORWARDED_PREFIX;

     /**
     * Determine if the given request should be trusted.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
     protected function shouldBeTrusted($request): bool
     {
        $trustedIps = [
            '127.0.0.1',  // Localhost
            $request->server('SERVER_ADDR'),
            // Add any other IPs or ranges as needed.  For example:
            // '192.168.1.*',  // Local network range
            // '203.0.113.0/24', // CIDR range
        ];

        return IpUtils::checkIp($request->getClientIp(), $trustedIps);
    }
}