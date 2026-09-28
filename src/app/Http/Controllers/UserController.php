<?php

namespace App\Http\Controllers;

use App\Mail\AuthCompleteMail;
use App\Mail\FindPasswordMail;
use App\User;
use App\Mail\AuthMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Auth\Guard;
use TheSeer\Tokenizer\Exception;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    function loginView() {
        return view('user.login');
    }

    function registerView(Request $request) {
        $socialUser = Session::get('social_user');
        return view('user.register', ['socialUser' => $socialUser]);
    }

    function plushRegisterView(Request $request) {
        Session::forget('social_user');
        return redirect()->route('user.register');
    }

    function findIdView() {
        return view('user.find_id');
    }

    function findPwView() {
        return view('user.find_pw');
    }

    function emailAlreadyExist(Request $request) {
        $email = $request->query('email');
        return view('user.email_already_exist', ['email' => $email]);
    }

    function logout() {
        Session::flush();
        Auth::logout();
        return redirect()->route('user.login');
    }

    function login(Request $request) {
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string']
        ]);

        $user = User::where('email', $request['email'])->first();

        if (!$user) {
            // If user is not registered
            return redirect()
                ->route('user.loginView')
                ->withErrors(['USER_NOT_FOUND' => "이메일 또는 비밀번호가 일치하지 않습니다.\n다시 확인해주세요."]);
        } else if (!$user['email_verified_at']) {
            // If user email is not verified
            // 사용자 이메일을 에러와 함께 전송합니다. blade는 전달 받은 해당 이메일로 이메일 재인증을 요청합니다.
            return redirect()
                ->route('user.loginView')
                ->withErrors(['INVALID_VERIFICATION_EMAIL' => $user['email']]);
        } else if (!Hash::check($request['password'], $user['password']) || $user['social_id']) {
            // If password is incorrect
            return redirect()
                ->route('user.loginView')
                ->withErrors(['PASSWORD_INCORRECT' => "이메일 또는 비밀번호가 일치하지 않습니다.\n다시 확인해주세요."]);
        }

        Auth::login($user);

        Auth::attempt(['email' => $request['email'], 'password' => $request['password']]);

        return redirect()->route('lecture.mainView');
    }

    function findId(Request $request) {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'contact' => ['required', 'string', 'max:255']
        ]);

        $user = User::where([
                'name' => $request['name'],
                'contact' => $request['contact'],
                'social_id' => null                 //소셜회원이 아닌 회원만
                ])->first();

        if (!$user) {
            return redirect()
                ->route('user.findIdView')
                ->withErrors(['USER_NOT_FOUND' => '회원 정보가 일치하지 않습니다.']);
        }

        // 이메일 아이디의 일정부분을 가립니다.
        // 길이가 3 이하면 한 글자만 보여주고, 아니면 세 글자까지 보여집니다.
        $tmpPos = strpos($user['email'], '@');
        $emailId = substr($user['email'], 0, $tmpPos);
        $emailHost = substr($user['email'], $tmpPos);

        if (strlen($emailId) <= 3) {
            $length = 1;
        } else {
            $length = 3;
        }

        $emailId = substr($emailId, 0, $length).'****';
        $email = $emailId . $emailHost;


        return view('user.find_id_complete', ['email' => $email]);
    }

    function findPw(Request $request) {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'contact' => ['required', 'string', 'max:255']
        ]);

        $user = User::where([
            'name' => $request['name'],
            'contact' => $request['contact'],
            'email' => $request['email'],
            'social_id' => null                 //소셜회원이 아닌 회원만
        ])->first();

        if (!$user) {
            return redirect()
                ->route('user.findPwView')
                ->withErrors(['USER_NOT_FOUND' => '회원 정보가 일치하지 않습니다.']);
        }


        // 임시비밀번호 메일 전송 코드.
        $str = 'abcdefghijklmnopqrstuvwxyz0123456789!@#$%&*ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $max = strlen($str) - 1;
        $chr = '';
        $len = 8;

        for($i=0; $i<$len; $i++) {
            $chr .= $str[random_int(0, $max)];
        }

        $user->password = Hash::make($chr);
        $user->save();

        Mail::to($user['email'])->send(new FindPasswordMail($user['email'], $chr));

        return view('user.find_pw', ['complete' => true]);
    }

    function emailVerify(Request $request) {
        $email = $request->query('email');
        $code = $request->query('email_verify_code');

        $user = User::where([ 'email' => $email ])->first();

        if (!$user) {
            return redirect()->route('user.loginView')->withErrors(['USER_NOT_FOUND' => '존재하지 않는 유저입니다.']);
        } else if ($user['email_verify_code'] != $code) {
            return redirect()->route('user.loginView')->withErrors(['EXPIRED_CODE' => '만료된 인증코드 입니다.']);
        }

        $user->update([
            'email_verified_at' => date("Y-m-d h:i:s a", time()),
            'email_verify_code' => '' // Clear email verify code
        ]);
        Mail::to($request['email'])->send(new AuthCompleteMail($user)); // Send a verification complete email.


        return redirect()->route('user.loginView');
    }

    function register(Request $request) {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'min:2'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'contact' => ['required', 'string', 'max:255', 'unique:users'],
            'nickname' => ['required', 'string', 'max:255', 'min:2'],
            'gender' => ['required', 'string', 'regex:/^[1|2]$/'],
            'birthday' => ['required', 'string', 'regex:/^([0-9]{8,8})$/'],
            'agree1' => ['required'],
            'agree2' => ['required']
        ]);

        $userInfo = [
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'contact' => $request['contact'],
            'nickname' => $request['nickname'],
            'gender' => $request['gender'],
            'birthday' => $request['birthday']
        ];

        $socialUser = Session::get('social_user');
        if ($socialUser) {
            // SNS Register
            $userInfo['social_id'] = $socialUser['id'];
            $userInfo['email_verified_at'] = date("Y-m-d h:i:s a", time());
            Session::forget('social_user');

            $newUser = User::create($userInfo);
            Auth::login($newUser);

            return redirect()->route('user.loginView');
        } else {
            // General Register
            // 186
            $emailVerifyCode = uniqid();
            $userInfo['email_verify_code'] = $emailVerifyCode; // Add an email verify code into the user
            User::create($userInfo);
            Mail::to($request['email'])->send(new AuthMail($userInfo));
            return view('user.register_complete', ['user' => $userInfo]);
        }
    }

    function resendVerificationEmail(Request $request) {
        if (!$request->query('email')) {
            // 이메일 전달 받지 않았을 시
            return redirect()->back();
        }

        $user = User::where('email', $request->query('email'))->first();
        if (!$user) {
            return redirect()->back()->withErrors(['USER_NOT_FOUND' => '존재하지 않는 유저입니다.']);
        } else if ($user['email_verified_at']) {
            return redirect()->back()->withErrors(['ALREADY_VERIFIED' => '이미 이메일 검증된 유저입니다.']);
        }

        $emailVerifyCode = uniqid(); // 이메일 인증 코드 재생성
        $user->update([
            'email_verify_code' => $emailVerifyCode
        ]); // 이메일 인증코드 업데이트
        Mail::to($user['email'])->send(new AuthMail($user));

        return redirect()->back()->with(['RESENT_VERIFICATION_EMAIL' => "인증코드를 재전송 하였습니다.\n이메일을 확인해주세요."]);
    }

    function randKeyGenerate($length = 12) {
        $counter = ceil($length/4);
        // 0보다 작으면 안된다.
        $counter = $counter > 0 ? $counter : 1;

        $charList = array(
            array("0", "1", "2", "3", "4", "5","6", "7", "8", "9", "0"),
            array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z"),
            array("!", "@", "#", "%", "^", "&", "*")
        );
        $password = "";
        for($i = 0; $i < $counter; $i++)
        {
            $strArr = array();
            for($j = 0; $j < count($charList); $j++)
            {
                $list = $charList[$j];

                $char = $list[array_rand($list)];
                $pattern = '/^[a-z]$/';
                // a-z 일 경우에는 새로운 문자를 하나 선택 후 배열에 넣는다.
                if( preg_match($pattern, $char) ) array_push($strArr, strtoupper($list[array_rand($list)]));
                array_push($strArr, $char);
            }
            // 배열의 순서를 바꿔준다.
            shuffle( $strArr );

            // password에 붙인다.
            for($j = 0; $j < count($strArr); $j++) $password .= $strArr[$j];
        }
        // 길이 조정
        return substr($password, 0, $length);
    }

    function myInfoView(Request $request) {
        if ($request->has('state')) {
            return view('user.my_info', ['user' => Auth::user(), 'state' => $request['state']]);
        }
        else {
            return view('user.my_info', ['user' => Auth::user()]);
        }
    }

    function myInfoChange(Request $request) {
        if ($request->has('nickname')) {
            $request->validate([
                'nickname' => ['required', 'string', 'max:255', 'min:2'],
                'user' => ['required'],
            ]);

            $user = $request->get('user');
            $user->nickname = $request['nickname'];
            $user->save();

            return redirect()->back()->with(['NICKNAME_CHANGED' => true]);
        }
        else if ($request->has('password')) {
            $request->validate([
                'password' => ['required', 'string', 'min:8'],
                'new_password' => ['required', 'confirmed', 'string', 'min:8'],
            ]);

            $user = User::find(Auth::id());

            if (!Hash::check($request->password, $request->user()->password)) {
                return redirect()->back()->with(['INCORRECT_PASSWORD' => true]);
            }

            $user->password = Hash::make($request['new_password']);
            $user->save();

            return redirect()->back()->with(['PASSWORD_CHANGED' => true]);
        }
        else {
            return redirect()->back();
        }
    }

    function myInfoSecessionView(Request $request) {
        return view('user.secession');
    }

    function myInfoSecession(Request $request) {
        $request->validate([
            'required_check_box' => ['required'],
        ]);

        $user = User::find(Auth::id());
        $user->delete();

        return redirect()->route('user.logout');
    }
    function paymentView() {
        return view('user.payment');
    }

    function billingView() {

    }
}
