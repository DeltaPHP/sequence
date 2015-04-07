<?php

use Phinx\Migration\AbstractMigration;

class SequencesInitMysql extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     *
     * Uncomment this method if you would like to use it.
     *
    public function change()
    {
    }
    */
    
    /**
     * Migrate Up.
     */
    public function up()
    {
        $this->table('sequences')
            ->addColumn('name', 'string', array('limit' => 150))
            ->addColumn('value', 'integer', array('default' => null, "null" => false))
            ->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {

    }
}