<x-guest-layout>  
    <div class="bg-gray-100 flex items-center justify-center min-h-screen h-screen relative overflow-hidden">    
        <img src="{{ asset('icon/login.svg') }}" alt="Decorative Icon" class="absolute top-0 right-0 max-w-none w-full h-screen object-cover z-0" /> <!-- Ikon dekoratif kanan atas -->  
        <!-- <img src="{{ asset('icon/login.svg') }}" alt="Decorative Icon" class="absolute bottom-0 left-0 w-24 z-0" /> Ikon dekoratif kiri bawah   -->
          
        <div class="bg-white custom-rounded-box rounded-3xl shadow-md w-full max-w-md  z-50 overflow-hidden" style="padding: 4rem;">    
            <h2 class="text-center text-2xl font-bold mb-6 mt-8">Log In</h2> <!-- Judul -->  
              
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
                            class="block custom-input mt-1 w-full focus:border-gray-800 focus:ring-gray-800" 
                            type="text" 
                            name="login" 
                            :value="old('login')" 
                            required 
                            autofocus 
                            autocomplete="username" 
                            style="border-color: gray-800 !important;" 
                            />  
                </div>  
  
                <div class="mt-4">  
                    <x-label for="password" value="{{ __('Password') }}" />  
                    <div class="relative flex items-center">
                        <x-input id="password" 
                                class="block custom-input mt-1 w-full focus:border-gray-800 focus:ring-gray-800" 
                                type="password" 
                                name="password" 
                                required 
                                style="border-color: gray-800 !important;" 
                                autocomplete="current-password" />
                        <div class="absolute custom-right !important left-4 h-full pt-1 flex items-center pr-1">
                            <button type="button" 
                                    class="focus:outline-none" 
                                    id="togglePassword">
                                <i id="eyeIcon" class="fas fa-eye text-gray-400 hover:text-gray-600"></i>
                            </button>
                        </div>
                    </div>
                </div>  
  
                @if (Route::has('password.request'))  
                    <div class="mt-4 text-right">
                        <a class="text-sm text-gray-600 hover:text-red-500 underline !important" href="{{ route('password.request') }}">  
                            {{ __('Forgot your password?') }}  
                        </a>  
                    </div>
                @endif  

                <div class="mt-6 w-full">
                    <x-button class="bg-orange-500 custom-hover text-white font-bold py-4 px-6 rounded focus:outline-none focus:shadow-outline w-full flex justify-center"
                        style="hover:bg: #ffd9d0 !important;">
                        {{ __('Log in') }}
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
    a:hover {
    color: red !important;
}
.custom-right {
    right: 10px !important;
}
.custom-rounded-box {
    background-color: white;
    border-radius: 24px; /* Sudut lebih membulat */
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 400px;
    padding: 4rem;
    overflow: hidden;
    position: relative;
    z-index: 50;
    min-height: 500px; /* Tambahkan tinggi minimal */
    padding-top: 300px;
}
.custom-input {
    border: 1px solid #d1d5db; /* Default: gray-300 */
    padding: 0.5rem;
    border-radius: 6px;
    width: 100%;
    transition: border 0.3s ease-in-out;
}

.custom-input:focus {
    border-color: #1f2937 !important; /* Gray-800 */
    outline: none;
}

</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleButton = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');
        
        toggleButton.addEventListener('click', function() {
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        });
    });
</script>