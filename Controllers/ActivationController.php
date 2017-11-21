<?php

/**
 * use your namespace instead
 */
namespace Adil\WPPlugin\Controllers;

/**
*
*/
class ActivationController extends Controller
{
    public function activate()
    {
        $this->createTables();
    }

    public function createTables()
    {
        // $this->db->query(/*Some query*/);
    }

   
    public function deactivate()
    {
        $this->dropTables();
    }

    public function dropTables()
    {
        // $table = 'Some tables';
        // $this->db->query("DROP TABLE IF EXISTS {$table}");
    }

}
