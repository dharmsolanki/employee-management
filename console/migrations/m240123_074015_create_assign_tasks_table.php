<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%assign_tasks}}`.
 */
class m240123_074015_create_assign_tasks_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('assign_tasks', [
            'id' => $this->primaryKey(),
            'employee_id' => $this->integer()->notNull(),
            'task_name' => $this->string()->notNull(),
            'due_date' => $this->date()->notNull(),
            'priority' => $this->string()->notNull(),
            'description' => $this->text(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        // Add foreign key constraint if needed
        $this->addForeignKey(
            'fk-assign_tasks-employee_id',
            'assign_tasks',
            'employee_id',
            'user', // replace with the actual employee table name
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        // Drop foreign key first if added
        $this->dropForeignKey('fk-assign_tasks-employee_id', 'assign_tasks');

        // Drop the table
        $this->dropTable('assign_tasks');
    }
}
