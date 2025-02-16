<?php

namespace App\Http\Controllers;  
  
use Illuminate\Http\Request;  
  
class DashboardController extends Controller  
{  
    public function admin()  
    {  
        return view('dashboard'); // Ganti 'dashboard' dengan nama view yang sesuai  
    }  
}  

