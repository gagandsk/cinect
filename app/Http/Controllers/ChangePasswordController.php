<?php
   
namespace App\Http\Controllers;
   
use Illuminate\Http\Request;
use App\Rules\Password;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
  
class ChangePasswordController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
   
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('profile.profilePassword');
    } 
   
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function store(Request $request)
    {
        $current_password = $request->input('current_password');
        $update_password = $request->input('update_password');
        $update_confirm_password = $request->input('update_confirm_password');

        $request->validate([
            'current_password' => new Password,
            'update_password' => 'min:6',
            'update_confirm_password' => 'min:6|same:update_password',
        ]);
   
        User::find(auth()->user()->id)->update(['password'=> $request->update_password]);
        return view('profile.profile');
    }
}