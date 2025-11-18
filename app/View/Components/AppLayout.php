<?php

namespace App\View\Components;

// app/View/Components/AppLayout.php

use Illuminate\View\Component;
use Illuminate\View\View;

class AppLayout extends Component
{
    public function render(): View
    {
        return view('components.layouts.app');
    }
}