<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class AddedPriceLevelToSystemCategories extends AbstractMigration
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

        $this->table('system_categories')
            ->addColumn('price_level_id', 'integer', [
                'after' => 'classification',
                'default' => null,
                'length' => null,
                'null' => true,
                'signed' => false,
            ])
            ->addIndex(
                [
                    'price_level_id',
                ],
                [
                    'name' => 'FK_system_categories_price_level_id_idx',
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
        $this->table('system_categories')
            ->removeIndexByName('FK_system_categories_price_level_id_idx')
            ->update();

        $this->table('system_categories')
            ->removeColumn('price_level_id')
            ->update();
    }
}
