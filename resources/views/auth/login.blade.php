<x-guest-layout>  
    <div class="bg-gray-100 flex items-center justify-center min-h-screen h-screen relative overflow-hidden">    
        <img src="{{ asset('icon/login.svg') }}" alt="Decorative Icon" class="absolute top-0 right-0 max-w-none w-full h-screen object-cover z-0" /> <!-- Ikon dekoratif kanan atas -->  
        <!-- <img src="{{ asset('icon/login.svg') }}" alt="Decorative Icon" class="absolute bottom-0 left-0 w-24 z-0" /> Ikon dekoratif kiri bawah   -->
          
        <div class="bg-white rounded-lg shadow-md w-full max-w-md  z-50 overflow-hidden" style="padding: 4rem;">    
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
                    <x-label for="login" value="{{ __('Email or Username') }}" />  
                    <x-input id="login" 
                            class="block mt-1 w-full" 
                            type="text" 
                            name="login" 
                            :value="old('login')" 
                            required 
                            autofocus 
                            autocomplete="username" />  
                </div>  
  
                <div class="mt-4">  
                    <x-label for="password" value="{{ __('Password') }}" />  
                    <x-input id="password" 
                            class="block mt-1 w-full" 
                            type="password" 
                            name="password" 
                            required 
                            autocomplete="current-password" />  
                </div>  
  
                @if (Route::has('password.request'))  
                    <div class="mt-2 text-right">
                        <a class="text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">  
                            {{ __('Forgot your password?') }}  
                        </a>  
                    </div>
                @endif  

                <div class="mt-6 w-full">
                    <x-button class="bg-orange-500 custom-hover text-white font-bold py-2 px-6 rounded focus:outline-none focus:shadow-outline w-full flex justify-center"
                        style="hover:bg: #ffd9d0 !important;">
                        {{ __('Log inn') }}
                    </x-button>
                </div>


            </form>  
        </div>    
    </div>    
</x-guest-layout>

<style>
    .custom-hover:hover {
        background-color: #ffd9d0 !important;
    }
</style>