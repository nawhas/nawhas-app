<?php

namespace App\Console\Commands\Database;

use Carbon\Carbon;
use DB;
use Exception;
use Illuminate\Console\Command;

class SyncDatabase extends Command
{
    /**
     * Ignore these tables.
     * @var array
     */
    const IGNORE = [
        'migrations',
    ];

    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'db:sync {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronize your dev db with the latest content from our production db.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $tables = $this->getTables();

        $this->comment('Tables selected: ');
        foreach ($tables as $table) {
            $this->comment("\t - $table");
        }

        $file = $this->dumpDatabase($tables);
        $this->emptyTables($tables);
        $this->import($file);

        $this->info('Completed sync successfully!');
    }

    private function getTables()
    {
        $tables = [];
        $ignored = $this->getIgnoredTables();

        // If no tables were specified, grab all tables from the local db.
        $result = DB::select('SHOW TABLES');
        array_map(function ($item) use (&$tables, $ignored) {
            $db = env('DB_DATABASE');
            $table = $item->{'Tables_in_' . $db};

            // Make sure not to include ignored tables.
            if (!in_array($table, $ignored)) {
                $tables[] = $table;
            }
        }, $result);

        return $tables;
    }

    private function getIgnoredTables()
    {
        return self::IGNORE;
    }

    private function dumpDatabase(array $tables)
    {
        $ssh = env('PRODUCTION_DB_SERVER_USER', 'forge');
        $host = env('PRODUCTION_DB_SERVER_HOST');
        $dbhost = env('PRODUCTION_DB_HOST', '127.0.0.1');
        $dbport = env('PRODUCTION_DB_PORT', 3306);
        $user = env('PRODUCTION_DB_USERNAME', 'forge');
        $password = env('PRODUCTION_DB_PASSWORD');
        $database = env('PRODUCTION_DB_DATABASE', 'nawhas');

        // Keep exports of different tables in different files.
        $hash = md5(implode(',', $tables));

        if (!$this->validateArgs($ssh, $host, $user, $password)) {
            $this->throwEnvironmentException();
        }

        $tables = implode(' ', $tables);
        $date = Carbon::now()->toDateString();
        $file = storage_path("db-$date-$hash.sql");

        // Check if the export has already run to prevent running it again.
        if ($this->fileExportExists($file)) {
            if (!$this->option('force')) {
                $this->comment('Export already exists. To re-export the database, delete the file at ' . $file);

                return $file;
            }

            unlink($file);
        }

        $ignore = '';
        foreach ($this->getIgnoredTables() as $table) {
            $ignore .= "--ignore-table=$database.$table ";
        }

        $cmd = "ssh $ssh@$host mysqldump --user=$user --password=$password --host=$dbhost --port=$dbport "
            . '--skip-lock-tables --skip-disable-keys --skip-add-locks --no-create-db --no-create-info --skip-comments '
            . $ignore . "$database $tables > $file";

        $this->comment('Exporting the production database...');
        exec($cmd);

        if (!$this->fileExportExists($file)) {
            throw new Exception("Looks like there was an error exporting the database. I don't know what went wrong.");
        }

        $this->info('Export completed.');

        return $file;
    }

    private function fileExportExists($file)
    {
        return file_exists($file);
    }

    /**
     * @param array $tables
     *
     * @throws Exception
     */
    private function emptyTables(array $tables)
    {
        $this->comment('Emptying tables in 5 seconds... Use CTRL+C to cancel.');
        sleep(5);
        $this->comment('Emptying tables now.');

        $this->comment('Temporarily disabling foreign key checks.');
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        try {
            foreach ($tables as $table) {
                DB::table($table)->truncate();
            }
            $this->info('Finished emptying tables.');
        } finally {
            // Make sure this always runs to prevent problematic results.
            $this->comment('Resetting foreign key checks.');
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
    }

    /**
     * @param $file
     *
     * @throws Exception
     */
    private function import($file)
    {
        $user = env('DB_USERNAME', 'homestead');
        $password = env('DB_PASSWORD', 'secret');
        $host = env('DB_HOST', 'localhost');
        $port = env('DB_PORT', '3306');
        $database = env('DB_DATABASE', 'nawhas');

        if (!$this->validateArgs($user, $password, $host, $port, $database)) {
            $this->throwEnvironmentException();
        }

        $this->comment('Importing tables now...');
        $cmd = "mysql -u $user --password=$password --host=$host --port=$port $database < $file";
        exec($cmd);
        $this->info('Finished importing tables.');
    }

    /**
     * @param array ...$args
     *
     * @return bool
     */
    private function validateArgs(...$args)
    {
        foreach ($args as $arg) {
            if (is_null($arg)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @throws Exception
     */
    private function throwEnvironmentException()
    {
        $msg = "You don't have the proper environment configured to perform this command. Check the wiki for details.";
        throw new Exception($msg);
    }
}
