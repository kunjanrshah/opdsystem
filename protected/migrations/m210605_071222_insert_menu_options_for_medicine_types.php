<?php
Yii::import('application.models.*');
Yii::import('application.models.base.*');
class m210605_071222_insert_menu_options_for_medicine_types extends CDbMigration
{
	public function up()
	{
		//Insert parent
		//Yii::app()->db->createCommand('insert into menus_master (id, menu_title, page_url, parent_id) VALUES (null, "Medicine types", "medicinetypes/index", "0")')->execute();

		$command = Yii::app()->db->createCommand();

		$command->insert('menus_master', array(
			'menu_title' => "Medicine types",
			'page_url' => "medicinetypes/index",
			'parent_id' => '0'
		));

		$last_id = Yii::app()->db->getLastInsertID();

		if (!empty($last_id)) {
			//Insert children

			//index
			$command = Yii::app()->db->createCommand();
			$command->insert('menus_master', array(
				'menu_title' => "Medicine types",
				'page_url' => "medicinetypes/index",
				'parent_id' => $last_id
			));

			//add
			$command = Yii::app()->db->createCommand();
			$command->insert('menus_master', array(
				'menu_title' => "Add Medicine types",
				'page_url' => "medicinetypes/add",
				'parent_id' => $last_id
			));

			//update
			$command = Yii::app()->db->createCommand();
			$command->insert('menus_master', array(
				'menu_title' => "Update Medi. type",
				'page_url' => "medicinetypes/update",
				'parent_id' => $last_id
			));

			//delete
			$command = Yii::app()->db->createCommand();
			$command->insert('menus_master', array(
				'menu_title' => "Delete Medi. types",
				'page_url' => "medicinetypes/delete",
				'parent_id' => $last_id
			));
		}
	}

	public function down()
	{
		echo "m210605_071222_insert_menu_options_for_medicine_types does not support migration down.\n";
		return false;
	}
}
