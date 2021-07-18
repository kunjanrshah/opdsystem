<?php

class m210718_143603_add_days_colssss extends CDbMigration
{
	public function up()
	{
		Yii::app()->db->createCommand('alter table diagnosis_treatments add column `days` varchar(5);')->execute();
		return false;
	}

	public function down()
	{
		echo "m210718_143603_add_days_colssss does not support migration down.\n";
		return false;
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}