<x-guest-layout>
    <div class="bg-gray-100 flex items-center justify-center min-h-screen">
        <div class="bg-white rounded-lg shadow-md w-full max-w-md p-8">
            <h2 class="text-center text-2xl font-bold mb-6">Reset Password</h2>

            <x-validation-errors class="mb-4" />

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div>
                    <x-label for="email" value="{{ __('Email') }}" />
                    <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
                </div>

                <div class="mt-6">
                    <x-button class="bg-orange-500 custom-hover text-white font-bold py-2 px-6 rounded w-full flex justify-center">
                        {{ __('Send Reset Link') }}
                    </x-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
