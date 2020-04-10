<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ChangeUserPassword;
use App\User;

class PasswordController extends Controller
{
    /**
     * Show edit password form
     * 
     * @return \Illuminate\Http\Response
     */
    public function editPassword()
    {
        return view('auth.passwords.change');
    }

    /**
     * Change user password
     * 
     * @param \Illuminate\Http\Requests\ChangeUserPassword
     * 
     * @return \Illuminate\Http\Response 
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
