<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_wallet}}`.
 */
class m200417_114242_create_user_wallet_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_wallet}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'sum' => $this->decimal(6, 2)->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_wallet}}');
    }
}
