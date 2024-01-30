<?php

use yii\db\Migration;

/**
 * Class m240122_121203_add_reject_reason_column_to_leave_applications
 */
class m240122_121203_add_reject_reason_column_to_leave_applications extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%leave_applications}}', 'reject_reason', $this->text()->after('status'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%leave_applications}}', 'reject_reason');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240122_121203_add_reject_reason_column_to_leave_applications cannot be reverted.\n";

        return false;
    }
    */
}
