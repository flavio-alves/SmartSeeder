<?php namespace Jlapp\SmartSeeder;

use Illuminate\Database\Migrations\MigrationCreator;

/**
 * Class SeedMigrationCreator
 *
 * @package Jlapp\SmartSeeder
 */
class SeedMigrationCreator extends MigrationCreator
{
    /**
     * Get the path to the stubs.
     *
     * @return string
     */
    public function getStubPath()
    {
        return __DIR__ . '/stubs';
    }
} 