<?php
namespace common\tests\unit\models;

use Yii;
use common\fixtures\UserFixture as UserFixture;

class BalancesTest extends \Codeception\Test\Unit
{
    /**
     * @var \common\tests\UnitTester
     */
    protected $tester;



    /**
     * Test add cash by user with role admin
     */
    public function testAddCash()
    {
        $model = new \common\models\Balance([
            'user_id' => 2,
            'value' => rand(1, 1351453),
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        expect($model->save());

    }

    /**
     * Test save model Balance with empty data-attributes
     */
    public function testEmptyData()
    {
        $model = new \common\models\Balance();

        expect_not($model->validate());
        expect_not($model->save());
    }
}