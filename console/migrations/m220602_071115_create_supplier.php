<?php

use yii\db\Migration;
use yii\db\mysql\Schema;

class m220602_071115_create_supplier extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%supplier}}', [
            'id' => $this->primaryKey()->unsigned()->notNull(),
            'name' => $this->string(50)->notNull()->defaultValue(''),
            'code' => "char(3) CHARACTER SET ascii COLLATE ascii_general_ci DEFAULT NULL",
            't_status' => "enum('ok','hold') CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL DEFAULT 'ok'",
        ], $tableOptions);
        $this->execute('ALTER TABLE `supplier` ADD UNIQUE INDEX `uk_code`(`code`) USING BTREE;');

    }

    public function down()
    {
        $this->dropTable('{{%supplier}}');
    }
}
