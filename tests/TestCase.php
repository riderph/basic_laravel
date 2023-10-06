<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Truncate data tables.
     * 
     * @return void
     */
    protected function truncateDataTables(array $tables = []): void
    {
        foreach ($tables as $table) {
            \DB::table($table)->truncate();
        }
    }
}
