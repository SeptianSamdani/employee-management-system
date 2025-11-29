<?php

namespace App\Livewire\Profile;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class ChangePassword extends Component
{
    public $current_password = '';
    public $new_password = '';
    public $new_password_confirmation = '';

    protected $rules = [
        'current_password' => 'required',
        'new_password' => 'required|min:8|confirmed|different:current_password',
        'new_password_confirmation' => 'required',
    ];

    protected $messages = [
        'current_password.required' => 'Password lama wajib diisi.',
        'new_password.required' => 'Password baru wajib diisi.',
        'new_password.min' => 'Password baru minimal 8 karakter.',
        'new_password.confirmed' => 'Konfirmasi password tidak cocok.',
        'new_password.different' => 'Password baru harus berbeda dengan password lama.',
        'new_password_confirmation.required' => 'Konfirmasi password wajib diisi.',
    ];

    public function updatePassword()
    {
        $this->validate();

        $user = Auth::user();

        // Verify current password
        if (!Hash::check($this->current_password, $user->password)) {
            $this->addError('current_password', 'Password lama tidak sesuai.');
            return;
        }

        // Update password
        $user->update([
            'password' => Hash::make($this->new_password),
        ]);

        // Reset form
        $this->reset(['current_password', 'new_password', 'new_password_confirmation']);

        session()->flash('message', 'Password berhasil diubah.');
        
        // Optional: Logout user setelah ganti password
        // Auth::logout();
        // return redirect()->route('login')->with('message', 'Password berhasil diubah. Silakan login kembali.');
    }

    public function render()
    {
        return view('livewire.profile.change-password');
    }
}