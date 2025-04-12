<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%short_url}}`.
 */
class m250410_133642_create_short_url_table extends Migration
{


    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = $this->db->driverName === 'mysql' ? 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB' : null;

        $fields = [
            'id' => $this->primaryKey(),
            'url' => $this->text()->notNull(),
            'short' => $this->string(48)->notNull()->unique(),
            'status' => $this->tinyInteger(1)->notNull()->defaultValue(1),
            'created_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'hits' => $this->integer()->notNull()->unsigned()->defaultValue(0),

        ];

        $this->createTable('{{%short_url}}', $fields, $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%short_url}}');
    }
}
