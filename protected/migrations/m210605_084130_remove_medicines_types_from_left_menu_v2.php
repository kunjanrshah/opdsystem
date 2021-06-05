<?php

class m210605_084130_remove_medicines_types_from_left_menu_v2 extends CDbMigration
{
	public function up()
	{
		Yii::app()->db->createCommand('update menus_master SET show_in_menu="0" WHERE page_url="medicinetypes/index"')->execute();

	}

	public function down()
	{
		echo "m210605_084130_remove_medicines_types_from_left_menu_v2 does not support migration down.\n";
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