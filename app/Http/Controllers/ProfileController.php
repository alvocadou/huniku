<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit', [
            'user' => auth()->user(),
        ]);
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $user->name = $data['name'];
        $user->email = $data['email'];

        if (! empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();

        return back()->with('status', 'Profil berhasil diupdate.');
    }

    public function becomeDeveloperForm()
    {
        $user = auth()->user();

        if ($user->isDeveloper()) {
            return redirect()->route('profile.edit');
        }

        return view('profile.become-developer');
    }

    public function becomeDeveloper(Request $request)
    {
        $user = auth()->user();

        if ($user->isDeveloper()) {
            return redirect()->route('profile.edit');
        }

        $data = $request->validate([
            'company_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'whatsapp' => ['nullable', 'string', 'max:30'],
            'instagram' => ['nullable', 'string', 'max:100'],
        ]);

        $user->update([
            'user_type' => 'developer',
            'company_name' => $data['company_name'],
            'phone' => $data['phone'],
            'whatsapp' => $data['whatsapp'] ?? null,
            'instagram' => $data['instagram'] ?? null,
            'developer_status' => 'pending',
        ]);

        return redirect()->route('profile.edit')
            ->with('status', 'Pengajuan jadi developer udah dikirim! Tim Huniku bakal verifikasi dulu (biasanya 1x24 jam).');
    }
}