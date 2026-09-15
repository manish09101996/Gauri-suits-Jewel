<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Address;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class CustomerAccountController extends Controller
{
    // Auth Views
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('account.dashboard');
        }
        return view('storefront.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect()->intended(route('account.dashboard'))->with('success', 'Welcome back to Gauri Suits & Jewel.');
        }

        return back()->withErrors(['email' => 'Invalid credentials provided.'])->onlyInput('email');
    }

    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route('account.dashboard');
        }
        return view('storefront.auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'phone' => 'required|string|max:20',
            'password' => ['required', 'confirmed', Password::min(6)],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),
            'status' => 'active',
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('account.dashboard')->with('success', 'Your account has been created successfully!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'You have been logged out.');
    }

    public function showForgotPassword()
    {
        return view('storefront.auth.forgot-password');
    }

    // Customer Account Pages
    public function dashboard()
    {
        $user = Auth::user();
        $recentOrders = $user->orders()->latest()->limit(3)->with('items.product.images')->get();
        $totalOrders = $user->orders()->count();
        $totalSpent = $user->totalSpent();

        return view('storefront.account.dashboard', compact('user', 'recentOrders', 'totalOrders', 'totalSpent'));
    }

    public function profile()
    {
        $user = Auth::user();
        return view('storefront.account.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => ['nullable', 'confirmed', Password::min(6)],
        ]);

        if (!empty($validated['current_password'])) {
            if (!Hash::check($validated['current_password'], $user->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect.']);
            }
            $user->password = Hash::make($validated['new_password']);
        }

        $user->name = $validated['name'];
        $user->phone = $validated['phone'];
        $user->save();

        return back()->with('success', 'Profile updated successfully.');
    }

    public function orders()
    {
        $orders = Auth::user()->orders()
            ->with(['items.product.images', 'payment', 'shipment'])
            ->latest()
            ->paginate(10);

        return view('storefront.account.orders', compact('orders'));
    }

    public function orderDetail(string $id)
    {
        $order = Auth::user()->orders()
            ->with(['items.product.images', 'payment', 'shipment'])
            ->findOrFail($id);

        return view('storefront.account.order-detail', compact('order'));
    }

    public function addresses()
    {
        $addresses = Auth::user()->addresses()->latest()->get();
        return view('storefront.account.addresses', compact('addresses'));
    }

    public function storeAddress(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'nullable|string|max:100',
            'phone' => 'required|string|max:20',
            'address_line1' => 'required|string|max:255',
            'address_line2' => 'nullable|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'country' => 'nullable|string|max:100',
            'is_default' => 'nullable|boolean',
        ]);

        if (!empty($validated['is_default'])) {
            Auth::user()->addresses()->update(['is_default' => false]);
        }

        $validated['user_id'] = Auth::id();
        $validated['is_default'] = $request->boolean('is_default') || !Auth::user()->addresses()->exists();

        Address::create($validated);

        return back()->with('success', 'Address added successfully.');
    }

    public function deleteAddress(int $id)
    {
        $address = Auth::user()->addresses()->findOrFail($id);
        $address->delete();

        return back()->with('success', 'Address removed.');
    }

    public function setDefaultAddress(int $id)
    {
        Auth::user()->addresses()->update(['is_default' => false]);
        $address = Auth::user()->addresses()->findOrFail($id);
        $address->update(['is_default' => true]);

        return back()->with('success', 'Default address updated.');
    }
}
