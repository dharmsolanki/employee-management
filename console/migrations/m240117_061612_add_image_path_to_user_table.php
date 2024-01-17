<?php

use yii\db\Migration;

/**
 * Class m240117_061612_add_image_path_to_user_table
 */
class m240117_061612_add_image_path_to_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'image_path', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%user}}', 'image_path');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240117_061612_add_image_path_to_user_table cannot be reverted.\n";

        return false;
    }
    */
}
