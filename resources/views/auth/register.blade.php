<x-guest-layout>

    <div class="glass-card p-8 w-full max-w-md mx-auto">

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <!-- Name -->
            <div>
                <label for="name" class="block text-sm text-slate-300">
                    Name
                </label>

                <input
                    id="name"
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    required
                    autofocus
                    autocomplete="name"
                    class="mt-1 w-full rounded-xl bg-white/5 border border-white/10 text-slate-100 focus:border-white/20 focus:ring-0"
                >

                <x-input-error :messages="$errors->get('name')" class="mt-2 text-rose-400" />
            </div>

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
                    autocomplete="new-password"
                    class="mt-1 w-full rounded-xl bg-white/5 border border-white/10 text-slate-100 focus:border-white/20 focus:ring-0"
                >

                <x-input-error :messages="$errors->get('password')" class="mt-2 text-rose-400" />
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="block text-sm text-slate-300">
                    Confirm Password
                </label>

                <input
                    id="password_confirmation"
                    type="password"
                    name="password_confirmation"
                    required
                    autocomplete="new-password"
                    class="mt-1 w-full rounded-xl bg-white/5 border border-white/10 text-slate-100 focus:border-white/20 focus:ring-0"
                >

                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-rose-400" />
            </div>

            <div class="flex items-center justify-between pt-2">
                <a href="{{ route('login') }}"
                   class="text-sm text-slate-400 hover:text-slate-200 underline">
                    Already registered?
                </a>

                <button
                    class="px-5 py-2 rounded-xl bg-indigo-500/80 hover:bg-indigo-500 text-white shadow">
                    Register
                </button>
            </div>

        </form>
    </div>

</x-guest-layout>