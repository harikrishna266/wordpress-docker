<?php

class BuilderMigrations
{

    public function create_tables()
    {
        $this->load_migrations();
        create_templates_tables();
        create_printing_areas_tables();
        create_print_types_table();
        create_models_tables();
        create_fashion_designs_tables();
        create_print_area_model_cordinates_tables();

        $this->load_seeding_files();
        $this->run_data_seeding();
    }

    public function run_data_seeding()
    {
        create_printing_areas_sample();
        add_models_sample();
        add_print_area_model_coordinates_sample();
    }

    public function load_migrations()
    {
        require_once plugin_dir_path(dirname(__FILE__)) . 'migrations/templates.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'migrations/printing-areas.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'migrations/print-types.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'migrations/models.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'migrations/fashion-designs.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'migrations/print-area-model-coordinates.php';
    }

    public function load_seeding_files()
    {
        require_once plugin_dir_path(dirname(__FILE__)) . 'migrations/sample-values/print-areas-sample.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'migrations/sample-values/models-sample.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'migrations/sample-values/print-area-model-coordiantes-sample.php';
    }

}