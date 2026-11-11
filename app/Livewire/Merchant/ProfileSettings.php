<?php

namespace App\Livewire\Merchant;

use App\Models\Merchant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Title('Pengaturan Lapak & QRIS - PentaCart IDN')]
class ProfileSettings extends Component
{
    use WithFileUploads;

    public Merchant $merchant;

    public string $name = '';
    public string $phone = '';
    public string $location = '';
    public string $description = '';
    public string $keywords = '';
    public array $sessions = [];
    public bool $is_open = true;

    public array $presetTags = [
        'Makanan Berat',
        'Snack & Cemilan',
        'Minuman & Es',
        'Kopi',
        'Jasa & Pulsa',
        'Sarapan',
        'Kuliner Malam',
    ];

    public $new_qris = null;

    protected function rules(): array
    {
        return [
            'name' => 'required|string|min:3|max:100',
            'phone' => ['required', 'regex:/^(\+62|62|08)[0-9]{8,13}$/'],
            'location' => 'nullable|string|max:150',
            'description' => 'nullable|string|max:500',
            'keywords' => 'nullable|string|max:2000',
            'sessions' => 'array|max:4',
            'sessions.*.start' => 'required_with:sessions.*.end|date_format:H:i',
            'sessions.*.end' => 'required_with:sessions.*.start|date_format:H:i|after:sessions.*.start',
            'new_qris' => 'nullable|image|max:2048', // max 2MB
        ];
    }

    protected function messages(): array
    {
        return [
            'name.required' => 'Nama toko wajib diisi.',
            'phone.required' => 'Nomor WhatsApp wajib diisi.',
            'phone.regex' => 'Format WhatsApp harus diawali 08, 62, atau +62.',
            'sessions.*.start.date_format' => 'Format jam mulai harus JJ:MM.',
            'sessions.*.end.date_format' => 'Format jam selesai harus JJ:MM.',
            'sessions.*.end.after' => 'Jam tutup harus lebih besar dari jam buka.',
            'new_qris.image' => 'File QRIS harus berupa gambar (JPG, PNG, WEBP).',
            'new_qris.max' => 'Ukuran gambar QRIS maksimal 2MB.',
        ];
    }

    public function mount()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $merchant = $user->merchant;
        if (!$merchant) {
            // Self-healing jika user belum punya merchant
            $merchant = Merchant::create([
                'user_id' => $user->id,
                'name' => $user->name . ' Shop',
                'slug' => Str::slug($user->name . '-' . $user->id),
                'phone' => '6281234567890',
                'is_open' => true,
            ]);
        }

        $this->merchant = $merchant;
        $this->name = $merchant->name;
        $this->phone = $merchant->phone;
        $this->location = $merchant->location ?? '';
        $this->description = $merchant->description ?? '';
        $this->keywords = $merchant->keywords ?? '';
        $this->sessions = $merchant->schedule ?? [];
        $this->is_open = $merchant->is_open;
    }

    public function addSession(): void
    {
        if (count($this->sessions) >= 4) {
            return;
        }

        $this->sessions[] = count($this->sessions) === 0
            ? ['start' => '13:00', 'end' => '14:30']
            : ['start' => '20:00', 'end' => '22:00'];
    }

    public function removeSession(int $index): void
    {
        unset($this->sessions[$index]);
        $this->sessions = array_values($this->sessions);
    }

    public function togglePresetKeyword(string $tag): void
    {
        $items = array_filter(array_map('trim', explode(',', $this->keywords)));
        $lowerMap = array_map('mb_strtolower', $items);
        $target = mb_strtolower($tag);

        if (($index = array_search($target, $lowerMap, true)) !== false) {
            unset($items[$index]);
        } else {
            $items[] = $tag;
        }

        $this->keywords = implode(', ', $items);
    }

    public function hasKeyword(string $tag): bool
    {
        $items = array_filter(array_map(fn ($v) => mb_strtolower(trim($v)), explode(',', $this->keywords)));
        return in_array(mb_strtolower($tag), $items, true);
    }

    public function toggleOpen()
    {
        $this->is_open = !$this->is_open;
        $this->merchant->update(['is_open' => $this->is_open]);
        session()->flash('status', 'Status toko berhasil diubah menjadi: ' . ($this->is_open ? 'BUKA' : 'TUTUP'));
    }

    public function updateProfile()
    {
        $this->validate();

        // Normalisasi format nomor WA jadi format 62...
        $cleanPhone = preg_replace('/[^0-9]/', '', $this->phone);
        if (str_starts_with($cleanPhone, '0')) {
            $cleanPhone = '62' . substr($cleanPhone, 1);
        }

        $cleanSchedule = collect($this->sessions)
            ->filter(fn ($s) => is_array($s) && ! empty($s['start']) && ! empty($s['end']))
            ->map(fn ($s) => ['start' => $s['start'], 'end' => $s['end']])
            ->sortBy('start')
            ->values()
            ->all();

        $data = [
            'name' => $this->name,
            'phone' => $cleanPhone,
            'location' => $this->location,
            'description' => $this->description,
            'keywords' => trim($this->keywords),
            'schedule' => empty($cleanSchedule) ? null : $cleanSchedule,
        ];

        // Jika upload QRIS baru
        if ($this->new_qris) {
            // Hapus QRIS lama jika ada
            if ($this->merchant->qris_image && Storage::disk('public')->exists($this->merchant->qris_image)) {
                Storage::disk('public')->delete($this->merchant->qris_image);
            }

            $path = $this->new_qris->store('qris-images', 'public');
            $data['qris_image'] = $path;
            $this->new_qris = null;
        }

        $this->merchant->update($data);
        $this->merchant->refresh();

        session()->flash('status', 'Profil lapak dan QRIS berhasil diperbarui!');
    }

    public function render()
    {
        return view('livewire.merchant.profile-settings');
    }
}
