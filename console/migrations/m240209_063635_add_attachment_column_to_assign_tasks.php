<?php

use yii\db\Migration;

/**
 * Class m240209_063635_add_attachment_column_to_assign_tasks
 */
class m240209_063635_add_attachment_column_to_assign_tasks extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('assign_tasks', 'attachment', $this->string()->after('description'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('assign_tasks', 'attachment');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240209_063635_add_attachment_column_to_assign_tasks cannot be reverted.\n";

        return false;
    }
    */
}
