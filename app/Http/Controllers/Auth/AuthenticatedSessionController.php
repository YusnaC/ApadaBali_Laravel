<?php  
  
  namespace App\Http\Controllers\Auth;  
 
  use App\Http\Controllers\Controller;  
  use Illuminate\Http\Request;  
  use Illuminate\Support\Facades\Auth;  
 
  class AuthenticatedSessionController extends Controller  
  {  
      public function create()  
      {  
          return view('auth.login'); // Adjust the view path as necessary  
      }  
 
      public function store(Request $request)  
      {  
          $request->validate([  
              'email' => 'required|email',  
              'password' => 'required',  
          ]);  
 
        if (Auth::attempt($request->only('email', 'password'))) {  
            if (Auth::user()->role === 'admin') {
                return redirect()->intended('/dashboard-admin');
            }
            return redirect()->intended('/dashboard-drafter');
        }  
 
          return back()->withErrors([  
              'email' => 'The provided credentials do not match our records.',  
          ]);  
      }  
 
      public function destroy(Request $request)  
      {  
          Auth::logout();  
          return redirect('/login');  
      }  
  }  
