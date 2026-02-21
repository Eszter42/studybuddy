<x-guest-layout>

    <div class="glass-card p-8 w-full max-w-md mx-auto">

        <x-auth-session-status class="mb-4 text-emerald-300" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm text-slate-300">
                    Email
                </label>

                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    autocomplete="username"
                    class="mt-1 w-full rounded-xl bg-white/5 border border-white/10 text-slate-100 focus:border-white/20 focus:ring-0"
                >

                <x-input-error :messages="$errors->get('email')" class="mt-2 text-rose-400" />
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm text-slate-300">
                    Password
                </label>

                <input
                    id="password"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    class="mt-1 w-full rounded-xl bg-white/5 border border-white/10 text-slate-100 focus:border-white/20 focus:ring-0"
                >

                <x-input-error :messages="$errors->get('password')" class="mt-2 text-rose-400" />
            </div>

            <!-- Remember -->
            <div class="flex items-center">
                <input
                    id="remember_me"
                    type="checkbox"
                    name="remember"
                    class="rounded border-white/20 bg-white/5 text-indigo-500 focus:ring-0"
                >

                <label for="remember_me" class="ms-2 text-sm text-slate-400">
                    Remember me
                </label>
            </div>

            <div class="flex items-center justify-end pt-2">
                <button
                    class="px-5 py-2 rounded-xl bg-indigo-500/80 hover:bg-indigo-500 text-white shadow">
                    Log in
                </button>
            </div>

        </form>
    </div>

</x-guest-layout>