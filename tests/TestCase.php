<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Vite assets are built locally/CI and are not needed to test server-rendered HTML,
        // so the suite must not depend on public/build/manifest.json existing.
        $this->withoutVite();
    }
}
