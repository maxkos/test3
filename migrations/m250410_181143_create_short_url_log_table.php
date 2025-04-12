<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%short_url_log}}`.
 */
class m250410_181143_create_short_url_log_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = $this->db->driverName === 'mysql' ? 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB' : null;

        $fields = [
            'id' => $this->primaryKey(),
            'short_url_id' => $this->integer()->notNull(),
            'ip' => $this->string(15)->notNull(),
            'user_agent' => $this->text(),
            'created_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
        ];
        $this->createTable('{{%short_url_log}}', $fields, $tableOptions);
        $this->createIndex('idx-short_url_log__short_url_id', '{{%short_url_log}}', 'short_url_id');
        $this->addForeignKey('fk-short_url_log__short_url', '{{%short_url_log}}', 'short_url_id', '{{%short_url}}', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-short_url_log__short_url', '{{%short_url_log}}');
        $this->dropIndex('idx-short_url_log__short_url_id', '{{%short_url_log}}');
        $this->dropTable('{{%short_url_log}}');
    }
}
