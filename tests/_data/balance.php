<?php
/**
 * Created by PhpStorm.
 * User: Cosmos
 * Date: 02.08.20
 * Time: 23:14
 */
return [
    [
        'user_id' => rand(2,\common\models\User::find()->max(['id'])->scalar()),
        'value' => rand(1,1000000)
    ],
    [
        'user_id' => rand(2,\common\models\User::find()->max(['id'])->scalar()),
        'value' => rand(1,1000000)
    ],
    [
        'user_id' => rand(2,\common\models\User::find()->max(['id'])->scalar()),
        'value' => rand(1,1000000)
    ],
    [
        'user_id' => rand(2,\common\models\User::find()->max(['id'])->scalar()),
        'value' => rand(1,1000000)
    ]
];