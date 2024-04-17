<?php

class BuilderMigrations
{

    public function createTables()
    {
        $this->loadMigrations();
        create_templates_tables();
    }

    public function loadMigrations()
    {
         require_once PLUGIN_ROOT. 'admin/migrations/templates.php';
    }

}