<?php
/**
 * Created by PhpStorm.
 * User: Cosmos
 * Date: 02.08.20
 * Time: 12:56
 */

use \common\models\User;

class m200802_115500_init_data extends \yii\db\Migration{

    public function safeUp()
    {
        foreach ([
                     [
                         'status'   => User::STATUS_ACTIVE,
                         'role'     => User::ROLE_ADMIN,
                         'username' => 'Admin',
                         'email'    => 'admin@money.ru',
                         'password' => 'W0bHcd8O9H0NBwKq',
                     ],
                     [
                         'status'   => User::STATUS_ACTIVE,
                         'role'     => User::ROLE_USER,
                         'username' => 'Bob',
                         'email'    => 'bob@money.ru',
                         'password' => 'D68y7xs5eEJtcbXx',
                     ],
                    [
                         'status'   => User::STATUS_ACTIVE,
                         'role'     => User::ROLE_USER,
                         'username' => 'Morley',
                         'email'    => 'morley@money.ru',
                         'password' => '4u5g345hJVGE5EGV',
                     ],
                    [
                         'status'   => User::STATUS_ACTIVE,
                         'role'     => User::ROLE_USER,
                         'username' => 'Stepan',
                         'email'    => 'stepan@money.ru',
                         'password' => '7WR8HFByuegy87fy',
                     ],
                    [
                         'status'   => User::STATUS_ACTIVE,
                         'role'     => User::ROLE_USER,
                         'username' => 'Ujin',
                         'email'    => 'ujin@money.ru',
                         'password' => 'vjnlwjih7yYDGGVK',
                     ],

                 ] as $userData) {
            $user = new User($userData);
            $user->generateAuthKey();

            if (!$user->save()) {
                \yii\helpers\Console::output(\yii\helpers\VarDumper::dumpAsString($user->getErrors()));
                throw new \yii\base\Exception('Unable to save user.');
            }
        }
    }

    public function safeDown()
    {

    }
} 