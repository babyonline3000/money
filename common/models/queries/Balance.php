<?php

namespace common\models\queries;

/**
 * This is the ActiveQuery class for [[\common\models\Balance]].
 *
 * @see \common\models\Balance
 */
class Balance extends \yii\db\ActiveQuery
{
	/**
	 * {@inheritdoc}
	 * @return \common\models\Balance[]|array
	 */
	public function all($db = null)
	{
		return parent::all($db);
	}

	/**
	 * {@inheritdoc}
	 * @return \common\models\Balance|array|null
	 */
	public function one($db = null)
	{
		return parent::one($db);
	}
}
