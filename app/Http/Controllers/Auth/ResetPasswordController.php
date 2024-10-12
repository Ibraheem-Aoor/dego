<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Models\Page;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    public function showResetForm(Request $request, $token = null)
    {
        $data['basicControl'] = basicControl();
        if ($data['basicControl']->theme == 'relaxation'){
            $data['content'] = Content::with('contentDetails')->where('name','relaxation_login')->first();
        }elseif ($data['basicControl']->theme == 'adventure'){
            $data['content'] = Content::with('contentDetails')->where('name','adventure_login')->first();
        }

        return view(template().'auth.passwords.reset', $data)->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    public function reset(Request $request)
    {

        $rules = [
            'email' => "required",
            'password' => "required|min:5",
            'password_confirmation' => "required|same:password",
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::where('email', $request->email)->first();
        if (!$user){
            return back()->with('error', 'User Not Found.');
        }

        try {
            $user->password = Hash::make($request->password);
            $user->save();

            return back()->with('success', 'Password Reset successfully.');

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

}
