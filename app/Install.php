<?php

namespace App;

use MadWeb\Initializer\Contracts\Runner;

class Install
{
    public function production(Runner $run)
    {
        $run->external('composer', 'install', '--no-interaction', '--optimize-autoloader')
            ->artisan('key:generate', ['--force' => true])
            ->artisan('migrate', ['--force' => true])
            ->artisan('storage:link')
            ->external('npm', 'install')
            ->external('npm', 'run', 'production')
            ->artisan('optimize:clear');
    }

    public function local(Runner $run)
    {
        $run->external('composer', 'install')
            ->artisan('key:generate')
            ->artisan('migrate')
            ->artisan('storage:link')
            ->external('npm', 'install')
            ->external('npm', 'run', 'development')
            ->artisan('optimize:clear');
    }
}
