<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%leave_applications}}`.
 */
class m240109_062310_create_leave_applications_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%leave_applications}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'leave_type' => $this->string()->notNull(),
            'start_date' => $this->date()->notNull(),
            'end_date' => $this->date()->notNull(),
            'reason' => $this->text()->notNull(),
            'status' => $this->string()->defaultValue('pending'),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        // Add foreign key constraint if needed
        $this->addForeignKey(
            'fk-leave_applications-user_id',
            'leave_applications',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Drop foreign key constraint if needed
        $this->dropForeignKey('fk-leave_applications-user_id', 'leave_applications');

        $this->dropTable('{{%leave_applications}}');
    }
}

