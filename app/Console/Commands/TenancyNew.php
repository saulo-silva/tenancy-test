<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Hyn\Tenancy\Models\Website;
use Hyn\Tenancy\Contracts\Repositories\WebsiteRepository;

use Hyn\Tenancy\Models\Hostname;
use Hyn\Tenancy\Contracts\Repositories\HostnameRepository;

class TenancyNew extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenancy:newhostname';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new hostname';

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
     * @return mixed
     */
    public function handle()
    {
        //
        $nameHostname = $this->ask('Digite o nome do hostname.');
        $website = new Website;
        app(WebsiteRepository::class)->create($website);

        $hostname = new Hostname;
        $hostname->fqdn = $nameHostname . '.tenancy.test';
        $hostname = app(HostnameRepository::class)->create($hostname);
        app(HostnameRepository::class)->attach($hostname, $website);
        $this->info('Hostname criado com sucesso. http://' . $nameHostname . '.tenancy.test');
    }
}
