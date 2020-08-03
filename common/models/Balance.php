<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;

/**
 * Balance model
 *
 * @property int $id
 * @property int $user_id
 * @property mixed $value
 * @property string $created_at
 */
class Balance extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%balance}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => \yii\behaviors\TimestampBehavior::class,
                'attributes' => [
                    self::EVENT_BEFORE_INSERT => ['created_at'],
                ],
                'value' => date('Y-m-d H:i:s'),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'value'], 'required'],
            [['user_id'], 'integer'],
            [['value'], 'default', 'value' => 0],
            [['value'], 'number', 'min' => 1, 'max' => 1000000],
            [['created_at'], 'string', 'max' => 15],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'                   => 'ID',
            'user_id'              => 'ID пользователя',
            'value'                => 'Сумма',
            'created_at'           => 'Дата создания',
        ];
    }

    /**
     * {@inheritdoc}
     * @return \common\models\queries\Balance the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\queries\Balance(get_called_class());
    }

    /**
     * {@inheritdoc}
     * @return \common\models\queries\User
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * @param $dataProvider
     * @return int
     */
    public static function getTotalBalance($dataProvider){
        $totalBalance = 0;

        foreach ($dataProvider as $item){
            $totalBalance += $item['value'];
        }

        return $totalBalance;
    }

}
