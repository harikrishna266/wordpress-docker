<?php

class Builder_Activator {


	public function activate() {
        $this->runMigrations();
    }

    private function runMigrations() {
        require_once  PLUGIN_ROOT . '/admin/migrations/create-tables.php';
        $activator = new BuilderMigrations();
        $activator->createTables();
    }

}
