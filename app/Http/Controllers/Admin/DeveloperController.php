<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class DeveloperController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->input('status', 'semua');

        $developers = User::query()
            ->where('user_type', 'developer')
            ->withCount('listings')
            ->when($filter !== 'semua', fn ($query) => $query->where('developer_status', $filter))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.developers.index', [
            'developers' => $developers,
            'statusFilter' => $filter,
            'pendingCount' => User::where('user_type', 'developer')->where('developer_status', 'pending')->count(),
        ]);
    }

    public function show(User $user)
    {
        $listings = $user->listings()->with('images')->latest()->paginate(9);

        return view('admin.developers.show', [
            'developer' => $user,
            'listings' => $listings,
        ]);
    }

    public function verify(User $user)
    {
        $user->update(['developer_status' => 'verified', 'developer_rejection_reason' => null]);

        return back()->with('status', $user->name . ' berhasil diverifikasi sebagai developer.');
    }

    public function reject(Request $request, User $user)
    {
        $request->validate([
            'rejection_reason' => ['nullable', 'string', 'max:500'],
        ]);

        $user->update([
            'developer_status' => 'rejected',
            'developer_rejection_reason' => $request->input('rejection_reason'),
        ]);

        return back()->with('status', 'Pendaftaran developer ' . $user->name . ' ditolak.');
    }
}