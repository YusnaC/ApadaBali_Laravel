<x-guest-layout>  
    <div class="bg-gray-100 flex items-center justify-center min-h-screen relative">    
        <img src="{{ asset('icon/login.svg') }}" alt="Decorative Icon" class="absolute top-0 right-0 w-full h-full object-cover z-0" /> <!-- Ikon dekoratif kanan atas -->  
        <!-- <img src="{{ asset('icon/login.svg') }}" alt="Decorative Icon" class="absolute bottom-0 left-0 w-24 z-0" /> Ikon dekoratif kiri bawah   -->
          
        <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md z-50">    
            <h2 class="text-center text-2xl font-bold mb-6">Log In</h2> <!-- Judul -->  
              
            <x-validation-errors class="mb-4" />  
  
            @if (session('status'))  
                <div class="mb-4 font-medium text-sm text-green-600">  
                    {{ session('status') }}  
                </div>  
            @endif  
  
            <form method="POST" action="{{ route('login') }}">  
                @csrf  
  
                <div>  
                    <x-label for="email" value="{{ __('Email') }}" />  
                    <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />  
                </div>  
  
                <div class="mt-4">  
                    <x-label for="password" value="{{ __('Password') }}" />  
                    <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />  
                </div>  
  
                <div class="block mt-4">  
                    <label for="remember_me" class="flex items-center">  
                        <x-checkbox id="remember_me" name="remember" />  
                        <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>  
                    </label>  
                </div>  
  
                <div class="flex items-center justify-between mt-4">  
                    @if (Route::has('password.request'))  
                        <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">  
                            {{ __('Forgot your password?') }}  
                        </a>  
                    @endif  
  
                    <x-button class="bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">  
                        {{ __('Log in') }}  
                    </x-button>  
                </div>  
            </form>  
        </div>    
    </div>    
</x-guest-layout>  
