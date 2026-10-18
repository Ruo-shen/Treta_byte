<?php

namespace App\Support;

/** Validates config/redirects.php so a bad entry can never create a loop or an open redirect. */
class Redirects
{
    /**
     * @param  array<string, string>  $map  old path => new path
     * @return array<string, string> the usable entries
     */
    public static function valid(array $map): array
    {
        $normalized = [];
        foreach ($map as $from => $to) {
            if (self::isFromPath($from) && self::isToPath($to)) {
                $normalized[self::trim($from)] = $to;
            }
        }

        // Drop self-redirects and entries that target another entry's source (loops/chains: point at the final URL).
        return array_filter($normalized, function (string $to, string $from) use ($normalized) {
            $target = self::trim((string) strtok($to, '?#'));

            return $target !== $from && ! isset($normalized[$target]);
        }, ARRAY_FILTER_USE_BOTH);
    }

    private static function isFromPath(mixed $path): bool
    {
        return is_string($path) && preg_match('#^/[A-Za-z0-9._~/%-]+$#', $path) === 1 && ! str_starts_with($path, '//');
    }

    /** Site-relative only: one leading slash, no scheme, no backslash, no whitespace or control characters. */
    private static function isToPath(mixed $path): bool
    {
        return is_string($path) && preg_match('#^/(?!/)[^\s\x5c\x00-\x1f]*$#', $path) === 1;
    }

    private static function trim(string $path): string
    {
        return $path === '/' ? '/' : rtrim($path, '/');
    }
}
