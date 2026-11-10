<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Masuk Lapak - PentaCart IDN')]
class Login extends Component
{
    public string $email = '';
    public string $password = '';
    public bool $remember = true;

    protected function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required|string',
        ];
    }

    protected function messages(): array
    {
        return [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Kata sandi wajib diisi.',
        ];
    }

    public function login()
    {
        $this->validate();

        $credentials = [
            'email' => strtolower(trim($this->email)),
            'password' => $this->password,
        ];

        if (!Auth::attempt($credentials, $this->remember)) {
            $this->addError('email', 'Email atau kata sandi yang Anda masukkan tidak sesuai.');
            return;
        }

        session()->regenerate();

        return $this->redirect(route('merchant.profile'), navigate: true);
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
