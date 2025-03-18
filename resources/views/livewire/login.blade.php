<div>  
    <div class="bg-gray-100 flex items-center justify-center min-h-screen">    
        <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md relative">    
            <img src="{{ asset('images/login.svg') }}" alt="Decorative Icon" class="absolute top-4 left-4 w-24" /> <!-- Ikon dekoratif -->  
            <h2 class="text-center text-2xl font-bold mb-6">Log In IN</h2> <!-- Judul -->  
            <form wire:submit.prevent="login">    
                <div class="mb-4">    
                    <label for="username" class="block text-gray-700 font-bold mb-2">Username</label>    
                    <input id="username" type="text" wire:model="username" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('username') border-red-500 @enderror" required>    
                    @error('username')    
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>    
                    @enderror    
                </div>    
                <div class="mb-6 relative">    
                    <label for="password" class="block text-gray-700 font-bold mb-2">Password</label>    
                    <input id="password" type="password" wire:model="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline @error('password') border-red-500 @enderror" required>    
                    @error('password')    
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>    
                    @enderror    
                </div>    
                <div class="flex items-center justify-between">    
                    <button type="submit" class="bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">    
                        Log In    
                    </button>    
                    <!-- <a class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" href="{{ route('password.request') }}">    
                        Forgot Password?    
                    </a>     -->
                </div>    
            </form>    
        </div>    
    </div>    
</div>  
