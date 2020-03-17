<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ChangeUserPassword;
use App\User;

class PasswordController extends Controller
{
    /**
     * 
     */
    public function editPassword()
    {
        return view('auth.passwords.change');
    }

    /**
     * 
     */
    public function changePassword(ChangeUserPassword $request)
    {
        $result = User::updatePassword($request->old_password, $request->password);

        if(!$result['ok']) {
            return redirect()->route('password.edit')->withErrors([
                'passwordError' => $result['message']
            ]);
        }

        return redirect()->route('password.edit');
    }
}
