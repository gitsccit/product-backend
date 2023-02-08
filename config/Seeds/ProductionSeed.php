<?php

use Migrations\AbstractSeed;

/**
 * Production seed.
 */
class ProductionSeed extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeds is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     *
     * @return void
     */
    public function run(): void
    {
        $this->execute(file_get_contents('production.sql', true));
    }
}
