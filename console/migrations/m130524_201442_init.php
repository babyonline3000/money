<?php

use common\models\User;
use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%users}}', [
            'id' => $this->primaryKey(),
            'email' => $this->string()->notNull()->unique(),
            'username' => $this->string()->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(User::STATUS_ACTIVE),
            'role' => $this->smallInteger()->notNull()->defaultValue(User::ROLE_USER),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'verification_token' => $this->string()->defaultValue(null),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime(),
            'last_login_at' => $this->dateTime(),
        ], $tableOptions);
        $this->createIndex('users_idx_status', '{{%users}}', 'status');
        $this->createIndex('users_idx_role', '{{%users}}', 'role');

        $this->createTable('{{%balance}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'value' => $this->decimal(10,2),
            'created_at' => $this->dateTime()->notNull(),
        ], $tableOptions);
        $this->createIndex('balance_idx_is_value', '{{%balance}}', 'value');
        $this->addForeignKey('balance_fk_user_id', '{{%balance}}', 'user_id', '{{%users}}', 'id', null, 'CASCADE');

    }

    public function down()
    {
        $this->dropTable('{{%users}}');
        $this->dropForeignKey('balance_fk_user_id', '{{%balance}}');
        $this->dropTable('{{%balance}}');
    }
}
