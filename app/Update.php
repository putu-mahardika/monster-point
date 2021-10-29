<?php

namespace App;

use MadWeb\Initializer\Contracts\Runner;

class Update
{
    public function production(Runner $run)
    {
        $run->artisan('down')
            ->external('git', 'add', '.')
            ->external('git', 'commit', '-m', '"Syncing"')
            ->external('git', 'pull', '--no-edit')
            ->external('composer', 'install', '--no-interaction', '--optimize-autoloader')
            ->artisan('migrate', ['--force' => true])
            ->external('npm', 'install')
            ->external('npm', 'run', 'production')
            ->artisan('optimize:clear')
            ->artisan('up');
            // ->artisan('queue:restart'); // ->artisan('horizon:terminate');
    }

    public function local(Runner $run)
    {
        $run->external('git', 'pull', '--no-edit')
            ->external('composer', 'install')
            ->external('npm', 'install')
            ->external('npm', 'run', 'development')
            ->artisan('migrate')
            ->artisan('optimize:clear');
    }
}
