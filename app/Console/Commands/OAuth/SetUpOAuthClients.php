<?php

namespace App\Console\Commands\OAuth;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Laravel\Passport\ClientRepository;
use Laravel\Passport\Passport;
use League\Flysystem\UnreadableFileException;

class SetUpOAuthClients extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'oauth:setup {--force} {--production}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set up OAuth Clients';

    /**
     * @var \Laravel\Passport\ClientRepository
     */
    private $clients;
    /**
     * @var \Illuminate\Filesystem\Filesystem
     */
    private $fs;

    /**
     * Create a new command instance.
     *
     * @param \Laravel\Passport\ClientRepository $clients
     */
    public function __construct(ClientRepository $clients, Filesystem $fs)
    {
        parent::__construct();
        $this->clients = $clients;
        $this->fs = $fs;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->comment('This command will help you set up OAuth Clients for the Nawhas.com frontend app(s).');

        $this->comment('Verifying installation prerequisites...');

        if (!env('FRONTEND_URL')) {
            $this->error('`FRONTEND_URL` env variable is missing or undefined.');

            return;
        }

        $this->comment('Generating keys in case they do not yet exist...');

        $this->call('passport:keys', ['--force' => $this->option('force')]);

        $this->comment('Setting key file permissions...');

        foreach ([
            Passport::keyPath('oauth-public.key'),
            Passport::keyPath('oauth-private.key'),
        ] as $keyFile) {
            $this->fs->chmod($keyFile, 0660);

            $permissions = $this->fs->chmod($keyFile);

            if ($permissions !== '0777') {
                throw new UnreadableFileException($keyFile . ' reads as ' . $permissions . ' instead of 0660');
            }
        }

        $this->comment('Creating clients...');

        $clients = [];

        // Production Client
        $clients[] = $this->clients->createPasswordGrantClient(
            null,
            'Nawhas.com',
            config('app.frontend_url') . '/auth/callback'
        );

        if (!$this->option('production')) {
            // Dev Server Client
            $clients[] = $this->clients->createPasswordGrantClient(
                null,
                'Nawhas.com',
                'http://localhost:8080/auth/callback'
            );
        }

        $this->info('Clients created successfully.');
    }
}
