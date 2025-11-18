<?php
// app/View/Components/Layouts/App.php

namespace App\View\Components\Layouts;

use Illuminate\View\Component;
use Illuminate\View\View;

class App extends Component
{
    public function render(): View
    {
        return view('components.layouts.app');
    }
}