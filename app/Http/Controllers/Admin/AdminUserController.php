<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AdminUserController extends Controller
{
    public function index()
    {
        $admins = Admin::with('roles')->latest()->paginate(15);
        $roles = Role::all();

        return view('admin.admins.index', compact('admins', 'roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'password' => ['required', Password::min(6)],
            'phone' => 'nullable|string|max:20',
            'role' => 'required|string|in:super_admin,admin,manager,order_manager,editor',
            'is_active' => 'boolean',
        ]);

        $admin = Admin::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone' => $validated['phone'] ?? null,
            'role' => $validated['role'],
            'is_active' => $request->boolean('is_active', true),
        ]);

        $roleRecord = Role::where('name', $validated['role'])->first();
        if ($roleRecord) {
            $admin->roles()->sync([$roleRecord->id]);
        }

        return back()->with('success', 'Admin staff user created.');
    }

    public function update(Request $request, Admin $admin)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email,' . $admin->id,
            'password' => ['nullable', Password::min(6)],
            'phone' => 'nullable|string|max:20',
            'role' => 'required|string|in:super_admin,admin,manager,order_manager,editor',
            'is_active' => 'boolean',
        ]);

        $admin->name = $validated['name'];
        $admin->email = $validated['email'];
        $admin->phone = $validated['phone'] ?? null;
        $admin->role = $validated['role'];
        $admin->is_active = $request->boolean('is_active', true);

        if (!empty($validated['password'])) {
            $admin->password = Hash::make($validated['password']);
        }

        $admin->save();

        $roleRecord = Role::where('name', $validated['role'])->first();
        if ($roleRecord) {
            $admin->roles()->sync([$roleRecord->id]);
        }

        return back()->with('success', 'Admin details updated.');
    }

    public function destroy(Admin $admin)
    {
        if ($admin->id === auth()->guard('admin')->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        $admin->delete();
        return back()->with('success', 'Admin user removed.');
    }
}
