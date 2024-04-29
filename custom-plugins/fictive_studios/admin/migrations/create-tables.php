<?php

class BuilderMigrations
{

    public function create_tables()
    {
        $this->load_migrations();
        create_templates_tables();
        create_printing_areas_tables();
        create_print_types_table();
        create_fashion_designs_tables();
        create_models_tables();

        $this->load_seeding_files();
        $this->run_data_seeding();
    }

    public function run_data_seeding()
    {
        create_printing_areas_table();
    }

    public function load_migrations()
    {
        require_once plugin_dir_path(dirname(__FILE__)) . 'migrations/templates.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'migrations/printing-areas.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'migrations/print-types.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'migrations/fashion-designs.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'migrations/models.php';
    }

    public function load_seeding_files()
    {
        require_once plugin_dir_path(dirname(__FILE__)) . 'migrations/sample-values/print-areas-sample.php';
    }

}