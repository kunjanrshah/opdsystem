<?php

class m210718_110059_add_days_column_in_diagnosis_treatments_table extends CDbMigration
{
	public function up()
	{
	}

	public function down()
	{
		Yii::app()->db->createCommand('alter table diagnosis_treatments add column days varchar(5);')->execute();
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