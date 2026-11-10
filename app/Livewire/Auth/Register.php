<?php

namespace App\Livewire\Auth;

use App\Models\Merchant;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Daftar Penjual - PentaCart IDN')]
class Register extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public string $shop_name = '';
    public string $phone = '';

    protected function rules(): array
    {
        return [
            'name' => 'required|string|min:3|max:100',
            'email' => 'required|email|max:150|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'shop_name' => 'required|string|min:3|max:100',
            'phone' => ['required', 'regex:/^(\+62|62|08)[0-9]{8,13}$/'],
        ];
    }

    protected function messages(): array
    {
        return [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            'shop_name.required' => 'Nama toko/lapak wajib diisi.',
            'phone.required' => 'Nomor WhatsApp wajib diisi.',
            'phone.regex' => 'Format WhatsApp harus diawali 08, 62, atau +62.',
        ];
    }

    public function register()
    {
        $this->validate();

        // Normalisasi format nomor WA jadi format 62...
        $cleanPhone = preg_replace('/[^0-9]/', '', $this->phone);
        if (str_starts_with($cleanPhone, '0')) {
            $cleanPhone = '62' . substr($cleanPhone, 1);
        }

        $user = DB::transaction(function () use ($cleanPhone) {
            $user = User::create([
                'name' => $this->name,
                'email' => strtolower(trim($this->email)),
                'password' => Hash::make($this->password),
            ]);

            $baseSlug = Str::slug($this->shop_name);
            $slug = $baseSlug;
            $counter = 1;
            while (Merchant::where('slug', $slug)->exists()) {
                $slug = "{$baseSlug}-{$counter}";
                $counter++;
            }

            Merchant::create([
                'user_id' => $user->id,
                'name' => $this->shop_name,
                'slug' => $slug,
                'phone' => $cleanPhone,
                'is_open' => true,
            ]);

            return $user;
        });

        Auth::login($user);

        session()->flash('status', 'Pendaftaran toko berhasil! Silakan upload QRIS toko Anda.');
        return $this->redirect(route('merchant.profile'), navigate: true);
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
}
