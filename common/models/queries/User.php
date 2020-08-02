<?php

namespace common\models\queries;

/**
 * This is the ActiveQuery class for [[\common\models\User]].
 *
 * @see \common\models\User
 */
class User extends \yii\db\ActiveQuery
{
	/**
	 * @return User
	 */
	public function active()
	{
		return $this->andWhere(['status' => \common\models\User::STATUS_ACTIVE]);
	}

	/**
	 * @param string $username
     * @return User
	 */
	public function byUsername($username)
	{
		return $this->andWhere(['username' => $username]);
	}

	/**
	 * @param string $email
	 * @return User
	 */
	public function byEmail($email)
	{
		return $this->andWhere(new \yii\db\Expression('LOWER({{email}}) = :email', ['email' => mb_strtolower($email)]));
	}

	/**
	 * {@inheritdoc}
	 * @return \common\models\User[]|array
	 */
	public function all($db = null)
	{
		return parent::all($db);
	}

	/**
	 * {@inheritdoc}
	 * @return \common\models\User|array|null
	 */
	public function one($db = null)
	{
		return parent::one($db);
	}
}
