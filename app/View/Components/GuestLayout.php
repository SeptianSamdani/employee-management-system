<?php

namespace App\View\Components;

// app/View/Components/GuestLayout.php

use Illuminate\View\Component;
use Illuminate\View\View;

class GuestLayout extends Component
{
    public function render(): View
    {
        return view('layouts.guest');
    }
}