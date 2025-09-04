<?php

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\TrustHosts as Middleware;
use Symfony\Component\HttpFoundation\IpUtils;

class TrustHosts extends Middleware
{
    /**
     * Get the host patterns that should be trusted.
     *
     * @return array<int, string|\Illuminate\Http\Request>
     */
    public function hosts(): array
    {
        return [
            $this->allSubdomainsOfApplicationUrl(),
        ];
    }

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
            $request->server('SERVER_ADDR'), // Server IP
            // Add any other IPs or ranges as needed.  For example:
            // '192.168.1.*',  // Local network range
            // '203.0.113.0/24', // CIDR range
        ];

        return IpUtils::checkIp($request->getClientIp(), $trustedIps);
    }
}