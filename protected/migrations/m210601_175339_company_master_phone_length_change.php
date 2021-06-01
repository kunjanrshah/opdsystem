<?php

class m210601_175339_company_master_phone_length_change extends CDbMigration
{
	public function up()
	{
		Yii::app()->db->createCommand('alter table company_master modify column phone_number varchar(255);')->execute();

	}

	public function down()
	{
		echo "m210601_175339_company_master_phone_length_change does not support migration down.\n";
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