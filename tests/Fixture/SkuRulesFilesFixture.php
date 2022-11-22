<?php
declare(strict_types=1);

namespace ProductBackend\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * SkuRulesFilesFixture
 */
class SkuRulesFilesFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'sku_rule_id' => 1,
                'file_id' => 1,
            ],
        ];
        parent::init();
    }
}
