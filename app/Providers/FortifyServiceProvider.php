<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Laravel\Fortify\Contracts\RegisterResponse;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract; // Add this line
class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    /* public function register(): void
    {
        
    } */

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
        
        Fortify::loginView(fn () => view('auth.login', ['type_menu' => '']));
        Fortify::requestPasswordResetLinkView(fn () => view('auth.forgot', ['type_menu' => '']));
        Fortify::resetPasswordView(fn ($request) => view('auth.reset', ['type_menu' => ''], ['request' => $request]));
        Fortify::registerView(fn () => view('auth.register', ['type_menu' => '']));
        Fortify::verifyEmailView(fn () => view('auth.verify', ['type_menu' => '']));
        
    }

    /**
     * Define your route model bindings, pattern filters, etc.
     */
    public function register()
    {
        // Redirect after login
        $this->app->instance(
        LoginResponseContract::class, new class implements LoginResponseContract {
                public function toResponse($request)
                {
                    if (Auth::user()->usertype === 'admin') {
                        return $request->wantsJson()
                            ? response()->json(['two_factor' => false])
                            : redirect()->intended(config('fortify.home_admin'));
                    } else if (Auth::user()->usertype === 'event organizer') {
                        return $request->wantsJson()
                            ? response()->json(['two_factor' => false])
                            : redirect()->intended(config('fortify.home_eo'));
                    } else {
                        return $request->wantsJson()
                            ? response()->json(['two_factor' => false])
                            : redirect()->intended(config('fortify.home'));
                    }
                }
            }
        );

        // Redirect after register
        $this->app->instance(
            RegisterResponse::class, new class implements RegisterResponse {
                public function toResponse($request)
                {
                    if (Auth::user()->usertype === 'event organizer') {
                        return $request->wantsJson()
                            ? response()->json(['two_factor' => false])
                            : redirect()->intended(config('fortify.home_eo'));
                    } elseif (Auth::user()->usertype === 'member') {
                        return $request->wantsJson()
                            ? response()->json(['two_factor' => false])
                            : redirect()->intended(config('fortify.home'));
                    }
                }
            }
        );
    }
}
