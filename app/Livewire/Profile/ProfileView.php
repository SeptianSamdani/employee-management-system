<?php

namespace App\Livewire\Profile;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ProfileView extends Component
{
    public $employee;
    public $user;
    public $activeTab = 'info'; // info, documents, password
    
    public function mount()
    {
        $this->user = Auth::user();
        $this->employee = $this->user->employee;
        
        if (!$this->employee) {
            session()->flash('error', 'Data karyawan tidak ditemukan.');
            return redirect()->route('dashboard');
        }
    }
    
    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
    }
    
    public function render()
    {
        return view('livewire.profile.profile-view');
    }
}