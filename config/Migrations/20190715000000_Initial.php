<?php

use Migrations\AbstractMigration;

class Initial extends AbstractMigration
{
    public function up()
    {
        $this->execute(file_get_contents('initial.sql', true));
    }

    public function down()
    {
        // Disable foreign kye checks
        $this->execute('SET FOREIGN_KEY_CHECKS = 0');

        // Construct a query that drops all tables in the current database
        $dbName = $this->getAdapter()->getOption('name');
        $tables = $this->getAdapter()->fetchAll("
            SELECT concat('DROP TABLE IF EXISTS `', table_name, '`;')
            FROM information_schema.tables
            WHERE table_schema = $dbName
        ");
        $sqls = array_map(function ($array) {
            $sql = $array[0];

            return strpos($sql, 'phinxlog') ? '' : $sql;
        }, $tables);
        $sql = implode($sqls);

        // Drops all tables
        $this->execute($sql);

        // Enable foreign kye checks
        $this->execute('SET FOREIGN_KEY_CHECKS = 1');
    }
}
