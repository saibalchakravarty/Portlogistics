<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Log;
use Storage;
use File;
use Config;
class DeleteExportFolderCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:csv_folder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To Delete Export CSV Folder on daily basis.';

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
     * Description : To Delete the export/date('d-m-Y') folder in schedular at night 12:05 AM
     * Author : Ashish Barick
     * 
     *
     * @return int
     */
    public function handle()
    {
        $configFilePath = Config::get('export.last_date_path');
        if(Storage::exists($configFilePath))
        {
            File::deleteDirectory(storage_path("app/public/".$configFilePath));
        }
         $this->info('Cron Command Run successfully!');
    }
}
