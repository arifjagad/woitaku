<?php

// app/Http/Controllers/Auth/LoginController.php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    // ...

    protected function authenticated($user)
    {
        if($user->usertype === 'admin') {
            return redirect()->route('dashboard');
        }else if($user->usertype === 'event organizer') {
            return redirect()->route('dashboard-eo');
        }else{
            return redirect()->route('/');
        }

        // Default redirect if no matching role is found
        return redirect('/');
    }

    // ...
}

