<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class EmployeeDocument extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'employee_id',
        'type',
        'title',
        'file_path',
        'file_name',
        'file_type',
        'file_size',
        'description',
        'expiry_date',
        'is_verified',
        'verified_by',
        'verified_at',
    ];

    protected $casts = [
        'expiry_date' => 'date',
        'is_verified' => 'boolean',
        'verified_at' => 'datetime',
        'file_size' => 'integer',
    ];

    // Relationships
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    // Accessors
    public function getFileSizeFormattedAttribute(): string
    {
        if (!$this->file_size) return '-';
        
        $units = ['B', 'KB', 'MB', 'GB'];
        $size = $this->file_size;
        $unit = 0;
        
        while ($size > 1024 && $unit < count($units) - 1) {
            $size /= 1024;
            $unit++;
        }
        
        return round($size, 2) . ' ' . $units[$unit];
    }

    public function getFileUrlAttribute(): string
    {
        return Storage::url($this->file_path);
    }

    public function getTypeNameAttribute(): string
    {
        $types = [
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

        return $types[$this->type] ?? $this->type;
    }

    public function getIsExpiredAttribute(): bool
    {
        if (!$this->expiry_date) return false;
        
        return $this->expiry_date->isPast();
    }

    public function getIsExpiringSoonAttribute(): bool
    {
        if (!$this->expiry_date) return false;
        
        return $this->expiry_date->diffInDays(now()) <= 30 && !$this->is_expired;
    }

    // Scopes
    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    public function scopeUnverified($query)
    {
        return $query->where('is_verified', false);
    }

    public function scopeExpired($query)
    {
        return $query->whereNotNull('expiry_date')
                     ->whereDate('expiry_date', '<', now());
    }

    public function scopeExpiringSoon($query)
    {
        return $query->whereNotNull('expiry_date')
                     ->whereDate('expiry_date', '>', now())
                     ->whereDate('expiry_date', '<=', now()->addDays(30));
    }

    // Methods
    public function verify(User $user): void
    {
        $this->update([
            'is_verified' => true,
            'verified_by' => $user->id,
            'verified_at' => now(),
        ]);
    }

    public function deleteFile(): void
    {
        if (Storage::disk('public')->exists($this->file_path)) {
            Storage::disk('public')->delete($this->file_path);
        }
    }

    // Boot
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($document) {
            $document->deleteFile();
        });
    }
}