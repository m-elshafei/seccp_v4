<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use App\Helpers\Helper;


class DatabaseDelete extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete old database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $path = database_path('backups');
        $files = File::glob("$path/*");
        $today = File::glob("$path/" . date('Y-m-d') . "*");
        $oldFiles = [];

        if ($files) {
            foreach ($files as $file) {
                if (!in_array($file, $today)) {
                    File::delete($file);
                    $oldFiles[] = $file;
                }
            }
        }

        if (!is_dir($path)) {
            mkdir($path, 0755, true);
        }

        if ($oldFiles != null) {
            $this->info("File\n\n".implode("\n",$oldFiles)."\n\ndeleted Successfully");
            $message = "File\n\n".implode("\n",$oldFiles)."\n\ndeleted Successfully";
        }else {
            $this->info("No files found to delete");
            $message = 'No sql files found to delete';
        }
    
        // Helper::SendTelegramNotifications('databaseDeleted', basename($file),8);

    }
}
