<?php
declare(strict_types=1);

namespace ProductBackend\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * KitRuleDetailsFixture
 */
class KitRuleDetailsFixture extends TestFixture
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
                'id' => 1,
                'kit_rule_id' => 1,
                'logic' => 'Lorem ipsum dolor sit amet',
                'relation' => 'Lorem ipsum dolor sit amet',
                'value' => 1,
                'bucket_id' => 1,
                'group_item_id' => 1,
                'sort' => 1,
            ],
        ];
        parent::init();
    }
}
