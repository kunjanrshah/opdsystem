<?php

class m210611_164031_remove_prefix_from_medicines extends CDbMigration
{
	public function up()
	{
		Yii::app()->db->createCommand('update medicine_master SET medicine_name=REPLACE(medicine_name, "Tab.", "");')->execute();
		Yii::app()->db->createCommand('update medicine_master SET medicine_name=REPLACE(medicine_name, "T.", "");')->execute();
		Yii::app()->db->createCommand('update medicine_master SET medicine_name=REPLACE(medicine_name, "Inj.", "");')->execute();
		Yii::app()->db->createCommand('update medicine_master SET medicine_name=REPLACE(medicine_name, "Syp.", "");')->execute();
		Yii::app()->db->createCommand('update medicine_master SET medicine_name=REPLACE(medicine_name, "Cap.", "");')->execute();

	}

	public function down()
	{
		echo "m210611_164031_remove_prefix_from_medicines does not support migration down.\n";
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