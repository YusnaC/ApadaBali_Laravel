<?php  
  
namespace Database\Seeders;  
  
use Illuminate\Database\Seeder;  
use App\Models\User;  
use Illuminate\Support\Facades\Hash;  
  
class UserSeeder extends Seeder  
{  
    public function run()  
    {  
        // Create Admin User  
        User::create([  
            'username' => 'admin123',
            'name' => 'Admin User',  
            'email' => 'admin@example.com',  
            'password' => Hash::make('admin'),
            'role' => 'admin',
            'address' => 'Jl. Raya Admin No. 123, Denpasar',
            'phone' => '081234567890',
        ]);  
  
        // Create Drafter User  
        User::create([  
            'username' => 'drafter123',
            'name' => 'Drafter User',  
            'email' => 'drafter@example.com',  
            'password' => Hash::make('drafter'),
            'role' => 'drafter',
            'address' => 'Jl. Raya Drafter No. 456, Denpasar',
            'phone' => '081234567891',
        ]);  
    }  
}
