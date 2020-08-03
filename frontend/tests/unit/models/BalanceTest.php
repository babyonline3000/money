<?php
namespace frontend\tests\unit\models;

use common\models\User;
use frontend\models\ContactForm;
use PHPUnit\Framework\TestResult;
use yii\mail\MessageInterface;

class BalanceTest extends \Codeception\Test\Unit
{

    /**
     * Test add cash by user with role admin
     */
    public function testAddCash()
    {
        $model = new \common\models\Balance();

        $model->attributes = [
            'user_id' => 3,
            'value' => 51685,
//            'created_at' => date('Y-m-d H:i:s'),
        ];

        expect_that($model->save());

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

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Count elements of an object
     * @link http://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     */
    public function count()
    {
        // TODO: Implement count() method.
    }

    public function run(TestResult $result = null)
    {
        // TODO: Implement run() method.
    }

    public function toString()
    {
        // TODO: Implement toString() method.
    }
}
