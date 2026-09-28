<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    function facebookRedirectToProvider() {
        return Socialite::driver('facebook')->redirect();
    }

    function facebookHandleProviderCallback(Request $request)
    {
        try {
            $user = Socialite::driver('facebook')->user();
            $socialUser = ['id' => $user['id'], 'email' => $user['email']];

            $userExist = User::where('social_id', $user['id'])->orWhere('email', $user['email'])->first();

            if (!$userExist) {
                // Unregistered User
                Session::put('social_user', $socialUser); // It used in registerView for checking whether user register with social account or not
                return redirect()->route('user.registerView');
            } else if ($userExist['social_id'] != $user['id'] || $userExist['email'] != $user['email']) {
                // If social account and registered account is not matched each other
                return redirect()
                    ->route('user.loginView')
                    ->withErrors(['EMAIL_ALREADY_EXIST' => "입력 하신 정보는 ".$userExist['email']."\n이메일로 이미 등록된 유저입니다."]);
//                return redirect()->route('user.emailAlreadyExist', ['email' => $userExist['email']]);
            } else {
                // Already exist user
                Auth::login($userExist);
                return redirect()->route('user.loginView');
            }
        } catch (\Exception $e) {
            return redirect()->route('user.loginView');
        }
    }

    function googleRedirectToProvider() {
        return Socialite::driver('google')->redirect();
    }

    function googleHandleProviderCallback(Request $request)
    {
        try {
            $user = Socialite::driver('google')->user();
            $socialUser = ['id' => $user['id'], 'email' => $user['email']];

            $userExist = User::where('social_id', $user['id'])->orWhere('email', $user['email'])->first();

            if (!$userExist) {
                // Unregistered User
                Session::put('social_user', $socialUser); // It used in registerView for checking whether user register with social account or not
                return redirect()->route('user.registerView');
            } else if ($userExist['social_id'] != $user['id'] || $userExist['email'] != $user['email']) {
                // If social account and registered account is not matched each other
                return redirect()
                    ->route('user.loginView')
                    ->withErrors(['EMAIL_ALREADY_EXIST' => "입력 하신 정보는 ".$userExist['email']."\n이메일로 이미 등록된 유저입니다."]);
//                return redirect()->route('user.emailAlreadyExist', ['email' => $userExist['email']]);
            } else {
                // Already exist user
                Auth::login($userExist);
                return redirect()->route('user.loginView');
            }
        } catch (\Exception $e) {
            return redirect()->route('user.loginView');
        }
    }

    function naverRedirectToProvider() {
        return Socialite::driver('naver')->redirect();
    }

    function naverHandleProviderCallback(Request $request)
    {
        try {
            $user = Socialite::driver('naver')->user();
            $socialUser = ['id' => $user['id'], 'email' => $user['email']];

            $userExist = User::where('social_id', $user['id'])->orWhere('email', $user['email'])->first();

            if (!$userExist) {
                // Unregistered User
                Session::put('social_user', $socialUser); // It used in registerView for checking whether user register with social account or not
                return redirect()->route('user.registerView');
            } else if ($userExist['social_id'] != $user['id'] || $userExist['email'] != $user['email']) {
                // If social account and registered account is not matched each other
                return redirect()
                    ->route('user.loginView')
                    ->withErrors(['EMAIL_ALREADY_EXIST' => "입력 하신 정보는 ".$userExist['email']."\n이메일로 이미 등록된 유저입니다."]);
//                return redirect()->route('user.emailAlreadyExist', ['email' => $userExist['email']]);
            } else {
                // Already exist user
                Auth::login($userExist);
                return redirect()->route('user.loginView');
            }
        } catch (\Exception $e) {
            return redirect()->route('user.loginView');
        }
    }

    function kakaoRedirectToProvider() {
        return Socialite::driver('kakao')->redirect();
    }

    function kakaoHandleProviderCallback(Request $request)
    {
        try {
            $user = Socialite::driver('kakao')->user();
            $socialUser = ['id' => $user['id'], 'email' => $user['kakao_account']['email']];

            $userExist = User::where('social_id', $user['id'])->orWhere('email', $user['kakao_account']['email'])->first();

            if (!$userExist) {
                // Unregistered User
                Session::put('social_user', $socialUser); // It used in registerView for checking whether user register with social account or not
                return redirect()->route('user.registerView');
            } else if ($userExist['social_id'] != $user['id'] || $userExist['email'] != $user['kakao_account']['email']) {
                // If social account and registered account is not matched each other
                return redirect()
                    ->route('user.loginView')
                    ->withErrors(['EMAIL_ALREADY_EXIST' => "입력 하신 정보는 ".$userExist['email']."\n이메일로 이미 등록된 유저입니다."]);
            } else {
                // Already exist user
                Auth::login($userExist);
                return redirect()->route('user.loginView');
            }
        } catch (\Exception $e) {
            return redirect()->route('user.loginView');
        }
    }
}
