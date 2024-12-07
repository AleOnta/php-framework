<?php

namespace App;

use PDO;
use App\Utility\AppConstants;

class MigrationRunner
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function migrate(): void
    {
        # get all applied migrations
        $appliedMigrations = $this->getAppliedMigrations();

        # get all available migration files
        $migrationFiles = glob(AppConstants::MIGRATIONS_DIR . '*.php');
        $migrationFiles = array_map(function ($el) {
            return pathinfo($el, PATHINFO_FILENAME) . '.php';
        }, $migrationFiles);

        # check for not applied migrations
        $toApplyMigrations = array_diff($migrationFiles, $appliedMigrations);
        if (count($toApplyMigrations) > 0) {
            # loop through all migrations to apply
            foreach ($toApplyMigrations as $migrationFile) {
                # import the migration file
                require_once AppConstants::MIGRATIONS_DIR . $migrationFile;
                # compose the migration classname
                $class = str_replace('.php', '', $migrationFile);
                $class = substr($class, 15);
                $class = explode('_', $class);
                $className = '';
                foreach ($class as $word) $className .= ucfirst($word);
                # create an instance of the migration
                $migration = new $className;
                # run the migration
                $migration->up($this->db);
                # record the migration
                $this->recordMigration($migrationFile, $className);
            }
        }
    }

    public function rollback(): void
    {
        # get the last applied migration
        $lastMigration = $this->getLastAppliedMigration();
        if ($lastMigration) {
            $lastMigration = $lastMigration[0];
            # import migration file
            require_once AppConstants::MIGRATIONS_DIR . $lastMigration['migration'];
            # create an instance of the migration
            $migration = new $lastMigration['classname'];
            # rollback the migration
            $migration->down($this->db);
            # discard the migration
            $this->discardMigration($lastMigration['migration']);
        }
    }

    # returns an array of strings containing all applied migrations
    private function getAppliedMigrations(): array
    {
        # creates the migrations table if not exist
        $this->db->exec("CREATE TABLE IF NOT EXISTS migrations (
            migration VARCHAR(100) PRIMARY KEY,
            classname VARCHAR(75) NOT NULL,
            applied_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );");
        # returns all migration records
        return $this->db->query("SELECT migration FROM migrations;")->fetchAll(PDO::FETCH_COLUMN);
    }

    private function recordMigration(string $migrationFile, $className): void
    {
        # compose INSERT query
        $stmt = $this->db->prepare("INSERT INTO migrations (migration, classname) VALUES (:migration, :classname);");
        $stmt->execute(['migration' => basename($migrationFile), 'classname' => $className]);
    }

    private function discardMigration($migrationFile): void
    {
        # compose DELETE query
        $stmt = $this->db->prepare("DELETE FROM migrations WHERE migration = :migration;");
        $stmt->execute(['migration' => basename($migrationFile)]);
    }

    private function getLastAppliedMigration(): array
    {
        # compose SELECT query
        $stmt = $this->db->query("SELECT migration, classname FROM migrations ORDER BY applied_at DESC LIMIT 1;");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
