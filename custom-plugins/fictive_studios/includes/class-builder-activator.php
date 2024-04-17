<?php

class Builder_Activator {


	public function activate() {
        $this->run_migrations();
    }

    private function run_migrations() {
        require_once  PLUGIN_ROOT . '/admin/migrations/create-tables.php';
        $activator = new BuilderMigrations();
        $activator->createTables();
    }

}
