<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPermissionsToTblAccessright extends Migration
{
     public function up()
    {
        $fields = [
            'can_view' => [
                'type'       => 'TINYINT',
                'default'    => 1,
                'after'      => 'menu_id',
            ],
            'can_create' => [
                'type'       => 'TINYINT',
                'default'    => 0,
                'after'      => 'can_view',
            ],
            'can_update' => [
                'type'       => 'TINYINT',
                'default'    => 0,
                'after'      => 'can_create',
            ],
            'can_delete' => [
                'type'       => 'TINYINT',
                'default'    => 0,
                'after'      => 'can_update',
            ],
        ];

        $this->forge->addColumn('tbl_accessright', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('tbl_accessright', ['can_view', 'can_create', 'can_update', 'can_delete']);
    }
}
