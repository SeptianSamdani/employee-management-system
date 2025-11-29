<?php

namespace App\Livewire\Profile;

use App\Models\EmployeeDocument;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class DocumentManagement extends Component
{
    use WithFileUploads, WithPagination;

    public $employee;
    public $showModal = false;
    
    // Form fields
    public $type = '';
    public $title = '';
    public $description = '';
    public $expiry_date = '';
    public $file;
    
    protected $rules = [
        'type' => 'required|in:ktp,kk,npwp,diploma,certificate,contract,bpjs_kesehatan,bpjs_ketenagakerjaan,medical,other',
        'title' => 'required|string|max:255',
        'description' => 'nullable|string|max:500',
        'expiry_date' => 'nullable|date|after:today',
        'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120', // 5MB
    ];

    protected $messages = [
        'type.required' => 'Tipe dokumen wajib dipilih.',
        'title.required' => 'Judul dokumen wajib diisi.',
        'file.required' => 'File dokumen wajib diunggah.',
        'file.mimes' => 'File harus berformat PDF, JPG, JPEG, atau PNG.',
        'file.max' => 'Ukuran file maksimal 5MB.',
        'expiry_date.after' => 'Tanggal kedaluwarsa harus setelah hari ini.',
    ];

    public function mount()
    {
        $this->employee = Auth::user()->employee;
        
        if (!$this->employee) {
            session()->flash('error', 'Data karyawan tidak ditemukan.');
            return redirect()->route('dashboard');
        }
    }

    public function openModal()
    {
        $this->reset(['type', 'title', 'description', 'expiry_date', 'file']);
        $this->resetValidation();
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset(['type', 'title', 'description', 'expiry_date', 'file']);
        $this->resetValidation();
    }

    public function upload()
    {
        $this->validate();

        try {
            // Generate unique filename
            $filename = time() . '_' . $this->file->getClientOriginalName();
            
            // Store file
            $path = $this->file->storeAs('employee-documents/' . $this->employee->id, $filename, 'public');

            // Create document record
            EmployeeDocument::create([
                'employee_id' => $this->employee->id,
                'type' => $this->type,
                'title' => $this->title,
                'description' => $this->description,
                'expiry_date' => $this->expiry_date,
                'file_path' => $path,
                'file_name' => $this->file->getClientOriginalName(),
                'file_type' => $this->file->getClientOriginalExtension(),
                'file_size' => $this->file->getSize(),
            ]);

            session()->flash('message', 'Dokumen berhasil diunggah.');
            
            $this->closeModal();
            
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal mengunggah dokumen: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $document = EmployeeDocument::where('employee_id', $this->employee->id)
                ->findOrFail($id);
            
            $document->delete(); // Boot method akan handle delete file
            
            session()->flash('message', 'Dokumen berhasil dihapus.');
            
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal menghapus dokumen: ' . $e->getMessage());
        }
    }

    public function download($id)
    {
        $document = EmployeeDocument::where('employee_id', $this->employee->id)
            ->findOrFail($id);
        
        return Storage::disk('public')->download($document->file_path, $document->file_name);
    }

    public function render()
    {
        $documents = EmployeeDocument::where('employee_id', $this->employee->id)
            ->latest()
            ->paginate(10);
        
        $documentTypes = [
            'ktp' => 'KTP',
            'kk' => 'Kartu Keluarga',
            'npwp' => 'NPWP',
            'diploma' => 'Ijazah',
            'certificate' => 'Sertifikat',
            'contract' => 'Kontrak Kerja',
            'bpjs_kesehatan' => 'BPJS Kesehatan',
            'bpjs_ketenagakerjaan' => 'BPJS Ketenagakerjaan',
            'medical' => 'Surat Keterangan Dokter',
            'other' => 'Lainnya',
        ];
        
        return view('livewire.profile.document-management', [
            'documents' => $documents,
            'documentTypes' => $documentTypes,
        ]);
    }
}