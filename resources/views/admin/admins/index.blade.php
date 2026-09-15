@extends('layouts.admin')

@section('title', 'Admin Staff & Permissions')

@section('content')
<div class="space-y-6" x-data="{ showModal: false, editMode: false, currentAdmin: {} }">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-white tracking-tight">Staff & Administrator Access</h1>
            <p class="text-sm text-slate-400">Manage store managers, order fulfillment officers, and permissions</p>
        </div>
        <button @click="showModal = true; editMode = false; currentAdmin = {}" class="inline-flex items-center gap-2 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-slate-950 font-semibold rounded-lg text-sm transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Add Staff Member
        </button>
    </div>

    @if ($errors->any())
        <div class="p-4 bg-rose-500/10 border border-rose-500/20 rounded-xl text-rose-400 text-sm">
            <div class="font-semibold mb-1">Please fix the errors below:</div>
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Staff Table -->
    <div class="bg-slate-900 border border-slate-800 rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-300">
                <thead class="bg-slate-800/60 text-xs uppercase font-semibold text-slate-400 tracking-wider border-b border-slate-800">
                    <tr>
                        <th class="px-6 py-4">User</th>
                        <th class="px-6 py-4">Role Assigned</th>
                        <th class="px-6 py-4">Contact Phone</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Created Date</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800">
                    @foreach($admins as $adm)
                    <tr class="hover:bg-slate-800/30 transition">
                        <td class="px-6 py-4">
                            <div class="font-semibold text-white">{{ $adm->name }}</div>
                            <div class="text-xs text-slate-400 font-mono">{{ $adm->email }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-500/10 text-amber-300 border border-amber-500/20 uppercase tracking-wider text-[11px]">
                                {{ str_replace('_', ' ', $adm->role) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-xs text-slate-300">
                            {{ $adm->phone ?? 'Not provided' }}
                        </td>
                        <td class="px-6 py-4">
                            @if($adm->is_active)
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">Active</span>
                            @else
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-800 text-slate-400 border border-slate-700">Suspended</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-xs text-slate-400">
                            {{ $adm->created_at->format('d M, Y') }}
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <button @click="showModal = true; editMode = true; currentAdmin = {{ json_encode($adm) }}" class="p-1.5 hover:bg-slate-800 text-slate-400 hover:text-amber-400 rounded transition inline-flex">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </button>
                            @if($adm->id !== auth('admin')->id())
                            <form action="{{ route('admin.admins.destroy', $adm->id) }}" method="POST" class="inline" onsubmit="return confirm('Remove this staff user?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1.5 hover:bg-slate-800 text-slate-400 hover:text-rose-400 rounded transition inline-flex">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Form for Create / Edit -->
    <div x-show="showModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70 backdrop-blur-sm" style="display: none;">
        <div @click.away="showModal = false" class="bg-slate-900 border border-slate-800 rounded-xl p-6 w-full max-w-lg shadow-2xl space-y-4">
            <h2 class="text-lg font-bold text-white" x-text="editMode ? 'Edit Staff Member' : 'Add New Staff Member'"></h2>

            <form :action="editMode ? `/admin/admins/${currentAdmin.id}` : '{{ route('admin.admins.store') }}'" method="POST" class="space-y-4">
                @csrf
                <template x-if="editMode">
                    <input type="hidden" name="_method" value="PUT">
                </template>

                <div>
                    <label class="block text-xs font-medium text-slate-300 mb-1">Full Name *</label>
                    <input type="text" name="name" :value="currentAdmin.name || ''" required class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3 py-2 text-sm text-white focus:border-amber-400 outline-none">
                </div>

                <div>
                    <label class="block text-xs font-medium text-slate-300 mb-1">Email Address *</label>
                    <input type="email" name="email" :value="currentAdmin.email || ''" required class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3 py-2 text-sm text-white focus:border-amber-400 outline-none">
                </div>

                <div>
                    <label class="block text-xs font-medium text-slate-300 mb-1" x-text="editMode ? 'New Password (Leave blank to retain current)' : 'Password *'"></label>
                    <input type="password" name="password" :required="!editMode" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3 py-2 text-sm text-white focus:border-amber-400 outline-none">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-slate-300 mb-1">Phone</label>
                        <input type="text" name="phone" :value="currentAdmin.phone || ''" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3 py-2 text-sm text-white focus:border-amber-400 outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-300 mb-1">Role *</label>
                        <select name="role" required class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3 py-2 text-sm text-white focus:border-amber-400 outline-none">
                            <option value="super_admin" :selected="currentAdmin.role === 'super_admin'">Super Admin</option>
                            <option value="admin" :selected="currentAdmin.role === 'admin'">Admin</option>
                            <option value="manager" :selected="currentAdmin.role === 'manager'">Manager</option>
                            <option value="order_manager" :selected="currentAdmin.role === 'order_manager'">Order Manager</option>
                            <option value="editor" :selected="currentAdmin.role === 'editor'">Content Editor</option>
                        </select>
                    </div>
                </div>

                <div class="pt-2">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" :checked="currentAdmin.is_active !== undefined ? currentAdmin.is_active : true" class="w-4 h-4 rounded bg-slate-800 border-slate-700 text-amber-500">
                        <span class="text-xs font-medium text-slate-300">Active account</span>
                    </label>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-800">
                    <button type="button" @click="showModal = false" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-lg text-xs font-semibold">Cancel</button>
                    <button type="submit" class="px-5 py-2 bg-amber-500 hover:bg-amber-600 text-slate-950 rounded-lg text-xs font-bold">Save Staff</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
