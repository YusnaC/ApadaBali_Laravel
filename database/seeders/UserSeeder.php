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
            'name' => 'Admin User',  
            'email' => 'admin@example.com',  
            'password' => Hash::make('admin'), // Password: admin  
            'role' => 'admin',  
        ]);  
  
        // Create Drafter User  
        User::create([  
            'name' => 'Drafter User',  
            'email' => 'drafter@example.com',  
            'password' => Hash::make('drafter'), // Password: drafter  
            'role' => 'drafter',  
        ]);  
    }  
}  
