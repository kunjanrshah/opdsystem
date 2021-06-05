<?php

class m210605_070809_add_medicine_types_table extends CDbMigration
{
	public function up()
    {
        $this->createTable('medicine_types', array(
            'id' => 'pk',
            'name' => 'string NOT NULL'
        ));
    }
 
    public function down()
    {
        $this->dropTable('medicine_types');
    }
}