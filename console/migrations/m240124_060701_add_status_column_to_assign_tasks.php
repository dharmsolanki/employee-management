<?php

use yii\db\Migration;

/**
 * Class m240124_060701_add_status_column_to_assign_tasks
 */
class m240124_060701_add_status_column_to_assign_tasks extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%assign_tasks}}', 'status', $this->integer()->defaultValue(0)->after('due_date'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%assign_tasks}}', 'status');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240124_060701_add_status_column_to_assign_tasks cannot be reverted.\n";

        return false;
    }
    */
}
