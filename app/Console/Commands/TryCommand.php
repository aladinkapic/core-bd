<?php

namespace App\Console\Commands;

use App\TryModel;
use Illuminate\Console\Command;

class TryCommand extends Command{
    protected $name        = 'create:TryCommand';
    protected $signature   = 'create:TryCommand';
    protected $description = 'That is just try command for scheduler : )';

    public function __construct(){
        parent::__construct();
    }

    public function handle(){
        TryModel::create([
            'title' => "I'm a title !",
        ]);
    }
}
