<?php

// Read by Laravel's TrustProxies middleware. Default: trust no proxy, so the client IP is the TCP peer.
// Behind a reverse proxy/CDN set TRUSTED_PROXIES to its IPs/CIDRs (comma separated), or '*' only if the app
// is reachable exclusively through that proxy; otherwise the contact rate limit sees one shared IP.
$proxies = trim((string) env('TRUSTED_PROXIES'));

return [
    'proxies' => match (true) {
        $proxies === '' => null,
        $proxies === '*' => '*',
        default => array_values(array_filter(array_map('trim', explode(',', $proxies)))),
    },
];
