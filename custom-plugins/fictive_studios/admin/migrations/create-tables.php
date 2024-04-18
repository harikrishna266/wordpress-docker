<?php

class BuilderMigrations
{

    public function createTables()
    {
        $this->loadMigrations();
        create_templates_tables();
        create_printing_areas_tables();
    }

    public function loadMigrations()
    {
         require_once PLUGIN_ROOT. 'admin/migrations/templates.php';
         require_once PLUGIN_ROOT. 'admin/migrations/printing-areas.php';
    }

}