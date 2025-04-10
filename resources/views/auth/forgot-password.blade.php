<x-guest-layout>
    <style>
        .custom-button {
            background-color: #FF6B35;
        }
        .custom-button:hover {
            background-color: #e65e2f;
        }
        .success-message {
            color: #059669;
            background-color: #ECFDF5;
            padding: 1rem;
            border-radius: 0.375rem;
            margin-bottom: 1rem;
        }
    </style>

    <div class="bg-gray-100 flex items-center justify-center min-h-screen">
        <div class="bg-white rounded-lg shadow-md w-full max-w-md p-8">
            <h2 class="text-center text-2xl font-bold mb-6">Reset Password</h2>

            @if (session('status'))
                <div class="success-message">
                    Link reset password telah terkirim ke email Anda. Silahkan periksa email Anda.
                </div>
            @endif

            <x-validation-errors class="mb-4" />

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div>
                    <x-label for="email" value="{{ __('Email') }}" />
                    <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
                </div>

                <div class="mt-6">
                <x-button class="custom-button text-white font-bold py-2 px-6 rounded w-full flex justify-center transition duration-200">
                    {{ __('Send Reset Link') }}
                </x-button>

                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
