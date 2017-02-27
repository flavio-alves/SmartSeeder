<?php

namespace Jlapp\SmartSeeder;

use File;
use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class SeedRollbackCommand
 *
 * @package Jlapp\SmartSeeder
 */
class SeedRollbackCommand extends Command
{
    use ConfirmableTrait;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'seed:rollback';

    /**
     * @var SeedMigrator
     */
    private $migrator;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rollback all database seeding';

    /**
     * SeedRollbackCommand constructor.
     *
     * @param SeedMigrator $migrator
     */
    public function __construct(SeedMigrator $migrator)
    {
        parent::__construct();

        $this->migrator = $migrator;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        if ( ! $this->confirmToProceed()) {
            return;
        }

        $this->migrator->setConnection($this->input->getOption('database'));

        $env = $this->option('env');

        if (File::exists(database_path(config('smart-seeder.seedsDir')))) {
            $this->migrator->setEnv($env);
        }

        $pretend = $this->input->getOption('pretend');
        $this->migrator->rollback($pretend);

        // Once the migrator has run we will grab the note output and send it out to
        // the console screen, since the migrator itself functions without having
        // any instances of the OutputInterface contract passed into the class.
        foreach ($this->migrator->getNotes() as $note) {
            $this->output->writeln($note);
        }
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    /*protected function getArguments()
    {
        return array(
            array('from', InputArgument::REQUIRED, 'The from date in the format dd-mm-yyyy.'),
            array('to', InputArgument::REQUIRED, 'The to date in the format dd-mm-yyyy.'),
        );
    }*/

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['env', null, InputOption::VALUE_OPTIONAL, 'The environment in which to run the seeds.', null],

            ['database', null, InputOption::VALUE_OPTIONAL, 'The database connection to use.'],

            ['pretend', null, InputOption::VALUE_NONE, 'Dump the SQL queries that would be run.'],

            ['force', null, InputOption::VALUE_NONE, 'Force the operation to run when in production.'],
        ];
    }
}