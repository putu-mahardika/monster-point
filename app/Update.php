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
            ->artisan('version:absorb')
            ->artisan('queue:work')
            ->artisan('horizon')
            ->artisan('optimize:clear')
            ->artisan('up');
    }

    public function local(Runner $run)
    {
        $run->external('git', 'pull', '--no-edit')
            ->external('composer', 'install')
            ->artisan('migrate')
            ->external('npm', 'install')
            ->external('npm', 'run', 'development')
            ->artisan('version:absorb')
            ->artisan('queue:work')
            ->artisan('horizon')
            ->artisan('optimize:clear');
    }
}
