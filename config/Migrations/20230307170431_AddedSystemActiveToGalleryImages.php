<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class AddedSystemActiveToGalleryImages extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    public function change(): void
    {
        $this->table('gallery_images')
            ->addColumn('system_active', 'string', [
                'after' => 'active',
                'default' => 'no',
                'null' => false,
                'limit' => null,
                'values' => ['yes', 'no'],
            ])
            ->update();
    }
}
