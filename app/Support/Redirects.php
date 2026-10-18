<?php

namespace App\Support;

/** Validates config/redirects.php so a bad entry can never create a loop, an open redirect or shadow a real route. */
class Redirects
{
    /** Paths that belong to the application; an entry may not redirect these away. */
    private const RESERVED_EXACT = ['/', '/services', '/work', '/about', '/blog', '/privacy', '/contact', '/sitemap.xml', '/robots.txt'];

    private const RESERVED_PREFIXES = ['/admin', '/livewire', '/filament', '/up', '/storage', '/build', '/css', '/js', '/fonts', '/images'];

    /**
     * @param  array<string, string>  $map  old path => new path
     * @return array<string, string> the usable entries
     */
    public static function valid(array $map): array
    {
        $normalized = [];
        foreach ($map as $from => $to) {
            if (self::isFromPath($from) && self::isToPath($to) && ! self::isReserved(self::trim($from))) {
                $normalized[self::trim($from)] = $to;
            }
        }

        // Drop self-redirects and entries that target another entry's source (loops/chains: point at the final URL).
        return array_filter($normalized, function (string $to, string $from) use ($normalized) {
            $target = self::trim((string) strtok($to, '?#'));

            return $target !== $from && ! isset($normalized[$target]);
        }, ARRAY_FILTER_USE_BOTH);
    }

    private static function isReserved(string $path): bool
    {
        $lower = strtolower($path);

        if (in_array($lower, self::RESERVED_EXACT, true)) {
            return true;
        }

        foreach (self::RESERVED_PREFIXES as $prefix) {
            if ($lower === $prefix || str_starts_with($lower, $prefix.'/')) {
                return true;
            }
        }

        return false;
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
