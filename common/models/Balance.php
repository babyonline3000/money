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
            [['user_id'], 'integer'],
            [['value'], 'number', 'min' => -1000000, 'max' => 1000000],
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
     * {@inheritdoc}
     * @param mixed $value
     * @param int $user_id
     * @return boolean
     */
    public function addMoney($value, $user_id)
    {
        $this->user_id = $user_id;
        $this->value = $value;

        if(!$this->save()){
            throw new \yii\base\Exception('Not add money by user.');
        }

        return true;
    }
}
