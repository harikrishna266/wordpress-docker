<?php

class BuilderMigrations
{

    public function createTables()
    {
        $this->loadMigrations();
        create_templates_tables();
        create_printing_areas_tables();
        create_print_types_table();
        create_fashion_designs_tables();
    }

    public function loadMigrations()
    {
        require_once plugin_dir_path(dirname(__FILE__)) . 'migrations/templates.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'migrations/printing-areas.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'migrations/print-types.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'migrations/fashion-designs.php';
    }

}