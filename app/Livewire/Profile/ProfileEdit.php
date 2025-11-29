<?php

namespace App\Livewire\Profile;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProfileEdit extends Component
{
    use WithFileUploads;

    public $employee;
    
    // Editable fields (yang boleh diubah employee)
    public $phone;
    public $address;
    public $photo;
    public $existing_photo;
    
    protected $rules = [
        'phone' => 'nullable|string|max:20',
        'address' => 'nullable|string|max:500',
        'photo' => 'nullable|image|max:2048',
    ];

    protected $messages = [
        'phone.max' => 'Nomor telepon maksimal 20 karakter.',
        'address.max' => 'Alamat maksimal 500 karakter.',
        'photo.image' => 'File harus berupa gambar.',
        'photo.max' => 'Ukuran foto maksimal 2MB.',
    ];

    public function mount()
    {
        $this->employee = Auth::user()->employee;
        
        if (!$this->employee) {
            session()->flash('error', 'Data karyawan tidak ditemukan.');
            return redirect()->route('dashboard');
        }
        
        $this->phone = $this->employee->phone;
        $this->address = $this->employee->address;
        $this->existing_photo = $this->employee->photo;
    }

    public function update()
    {
        $this->validate();

        DB::beginTransaction();
        
        try {
            $data = [
                'phone' => $this->phone,
                'address' => $this->address,
            ];

            // Handle photo upload
            if ($this->photo) {
                // Delete old photo
                if ($this->existing_photo) {
                    Storage::disk('public')->delete($this->existing_photo);
                }
                
                $data['photo'] = $this->photo->store('employees', 'public');
            }

            $this->employee->update($data);

            DB::commit();
            
            session()->flash('message', 'Profil berhasil diperbarui.');
            
            return redirect()->route('profile.index');
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            // Delete uploaded photo if transaction failed
            if ($this->photo && isset($data['photo'])) {
                Storage::disk('public')->delete($data['photo']);
            }
            
            session()->flash('error', 'Terjadi kesalahan saat memperbarui profil.');
        }
    }

    public function render()
    {
        return view('livewire.profile.profile-edit');
    }
}