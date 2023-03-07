<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class AddedCostAndSkuLookupTables extends AbstractMigration
{
    public $autoId = false;

    /**
     * Up Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-up-method
     * @return void
     */
    public function up(): void
    {

        $this->table('cost_locations')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('active', 'string', [
                'default' => 'no',
                'null' => false,
                'limit' => null,
                'values' => ['yes', 'no'],
            ])
            ->create();

        $this->table('erps')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('active', 'string', [
                'default' => 'no',
                'null' => false,
                'limit' => null,
                'values' => ['yes', 'no'],
            ])
            ->create();

        $this->table('product_cost_locations')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('product_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('cost_location_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('cost', 'float', [
                'default' => '0.00',
                'null' => false,
                'precision' => 8,
                'scale' => 2,
            ])
            ->addColumn('cost_maintenance', 'string', [
                'default' => 'manual',
                'limit' => null,
                'null' => false,
                'values' => ['manual', 'channel', 'erp'],
            ])
            ->addColumn('timestamp', 'timestamp', [
                'default' => 'CURRENT_TIMESTAMP',
                'update' => 'CURRENT_TIMESTAMP',
                'null' => false,
            ])
            ->addIndex(
                [
                    'product_id',
                    'cost_location_id',
                ],
                ['unique' => true]
            )
            ->addIndex(
                [
                    'timestamp',
                ]
            )
            ->create();

        $this->table('product_erps')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('product_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('erp_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('itemcode', 'string', [
                'default' => null,
                'limit' => 50,
                'null' => true,
            ])
            ->addIndex(
                [
                    'product_id',
                    'erp_id',
                ],
                ['unique' => true]
            )
            ->addIndex(
                [
                    'itemcode',
                ]
            )
            ->create();

        $this->table('product_cost_locations')
            ->addForeignKey(
                'product_id',
                'products',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE',
                ]
            )
            ->addForeignKey(
                'cost_location_id',
                'cost_locations',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE',
                ]
            )
            ->update();

        $this->table('product_erps')
            ->addForeignKey(
                'product_id',
                'products',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE',
                ]
            )
            ->addForeignKey(
                'erp_id',
                'erps',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE',
                ]
            )
            ->update();
    }

    /**
     * Down Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-down-method
     * @return void
     */
    public function down(): void
    {
        $this->table('product_cost_locations')
            ->dropForeignKey(
                'product_id'
            )
            ->dropForeignKey(
                'cost_location_id'
            )->save();

        $this->table('product_erps')
            ->dropForeignKey(
                'product_id'
            )
            ->dropForeignKey(
                'erp_id'
            )->save();

        $this->table('cost_locations')->drop()->save();
        $this->table('erps')->drop()->save();
        $this->table('product_cost_locations')->drop()->save();
        $this->table('product_erps')->drop()->save();
    }
}
