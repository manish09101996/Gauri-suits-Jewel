<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login | Gauri Suits &amp; Jewel</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
</head>
<body class="h-full bg-[#140D07] flex items-center justify-center p-4">
    <div class="w-full max-w-md bg-[#1B120C] border border-[#C5A869]/30 rounded-sm shadow-2xl p-8 text-[#F7EED9]">
        <!-- Brand Header -->
        <div class="text-center mb-8">
            <div class="w-16 h-16 mx-auto rounded-sm bg-[#58111A] text-[#F7EED9] flex items-center justify-center font-serif font-bold text-3xl border border-[#C5A869]/60 shadow-lg mb-4">
                G
            </div>
            <h1 class="font-serif text-2xl font-bold tracking-[0.2em] text-[#F7EED9] uppercase">GAURI</h1>
            <p class="text-[10px] tracking-[0.35em] text-[#C5A869] uppercase font-bold mt-0.5">Admin Command Center</p>
        </div>

        @if($errors->any())
            <div class="mb-6 p-3 bg-rose-950/80 border border-rose-800 text-rose-200 text-xs rounded-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-[#E3CE9B] mb-2">Email Address</label>
                <input type="email" name="email" value="{{ old('email', 'admin@gaurisuits.com') }}" required autofocus
                       class="w-full px-4 py-3 bg-[#140D07] border border-[#C5A869]/30 rounded-sm text-sm text-[#F7EED9] focus:outline-none focus:border-[#C5A869] transition-colors placeholder-[#8C713B]/40">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-[#E3CE9B] mb-2">Security Password</label>
                <input type="password" name="password" required
                       class="w-full px-4 py-3 bg-[#140D07] border border-[#C5A869]/30 rounded-sm text-sm text-[#F7EED9] focus:outline-none focus:border-[#C5A869] transition-colors placeholder-[#8C713B]/40"
                       placeholder="••••••••">
            </div>

            <div class="flex items-center justify-between text-xs text-[#E3CE9B]/80">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="remember" class="rounded bg-[#140D07] border-[#C5A869]/40 text-[#58111A] focus:ring-0">
                    <span>Remember Session</span>
                </label>
                <span class="text-[11px] text-[#C5A869]/70">Authorized Access Only</span>
            </div>

            <button type="submit"
                    class="w-full py-3.5 bg-[#58111A] hover:bg-[#7A1D2A] text-[#F7EED9] text-xs font-bold tracking-[0.25em] uppercase rounded-sm border border-[#C5A869]/50 transition-all duration-300 shadow-md">
                AUTHENTICATE &rarr;
            </button>
        </form>

        <div class="mt-8 pt-6 border-t border-[#C5A869]/20 text-center">
            <a href="{{ route('home') }}" class="text-xs text-[#C5A869] hover:underline tracking-wider">
                &larr; Return to Public Storefront
            </a>
        </div>
    </div>
</body>
</html>
