<?php

namespace App\Http\Controllers\Pages;

use Inertia\Inertia;
use Lit\Config\Form\Pages\MasterConfig;

class MasterController
{
    public function __invoke()
    {
        return Inertia::render('Master/Master', [
            'form' => MasterConfig::load()->resource()->toArray(request()),
        ]);
    }
}
