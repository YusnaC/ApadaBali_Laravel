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
              'login' => 'required', // Field for either username or email
              'password' => 'required',  
          ]);  
 
          $loginField = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
          $credentials = [
              $loginField => $request->login,
              'password' => $request->password
          ];
       
          if (Auth::attempt($credentials)) {  
              if (Auth::user()->role === 'admin') {
                  return redirect()->intended('/dashboard-admin');
              }
              return redirect()->intended('/dashboard-drafter');
          }  
 
          return back()->withErrors([  
              'login' => 'The provided credentials do not match our records.',  
          ]);  
      }  
 
      public function destroy(Request $request)  
      {  
          Auth::guard('web')->logout();  
          $request->session()->invalidate();  
          $request->session()->regenerateToken();  
          return redirect('/login')->with('loggedOut', true)  
          ->withHeaders([  
              'Cache-Control' => 'no-cache, no-store, max-age=0, must-revalidate',  
              'Pragma' => 'no-cache',  
              'Expires' => 'Fri, 01 Jan 1990 00:00:00 GMT',  
          ]);  
      }  
  }
