<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\OTPService;
use ErrorException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    protected $otpService;

    public function login(Request $request, string $type)
    {
        $rules[$type] = $type == 'mobile' ? 'required|numeric|digits_between:10,12' : 'required|string|email|max:120|min:2';
        validate()->make($rules + [
            'password' => 'required'
        ]);

        if (!Auth::attempt([$type => $request->{$type}, 'password' => $request->password])) {
            return error(message: ucfirst($type) . " & Password does not match with our record")->response();
        }
        $user = auth()->user();
        return success('Logged in Successfully', [
            'name' => $user->name,
            'email' => $user->email ?? null,
            'mobile' => $user->mobile ?? null,
            'role' => auth()->user()->role,
            'token' => auth()->user()->createToken("API TOKEN")->accessToken,
        ])->response();
    }

    public function requestOTP(Request $request, string $type)
    {
        $this->otpService = new OTPService;

        try {
            $rules[$type] = $type == 'mobile' ? 'required|numeric|unique:users,mobile|digits_between:10,12' : 'required|string|unique:users,email|email|max:120|min:2';

            validate()->make($rules);

            $otp = $this->otpService->sendOTP($type, $request->{$type});

            return success("OTP sent to requested $type", ['otp' => $otp])->response();
        } catch (ErrorException $e) {
            return error(message: $e->getMessage())->response();
        }
    }

    public function verifyOTP(Request $request, string $type)
    {
        $rules[$type] = $type == 'mobile' ? 'required|numeric|digits_between:10,12' : 'required|string|email|max:120|min:2';

        validate()->make($rules + [
            "otp" => ['required', 'numeric', 'digits:6'],
        ]);

        $token =  (new OTPService)->verify($request->{$type}, $request->otp);

        if (!$token) return error(message: 'Invalid OTP')->response();

        return success('OTP verification token', ['token' => $token])->response();
    }

    public function register(Request $request, string $type, OTPService $otpService)
    {
        $rules[$type] = $type == 'mobile' ? 'required|numeric|unique:users,mobile|digits_between:10,12' : 'required|string|unique:users,email|email|max:120|min:2';

        validate()->make($rules + [
            'token' => ['required', 'string'],
            'name' => 'bail|required|string|min:2|max:100|regex:/^[\pL\s]+$/u',
            'password' => ['required', 'confirmed', Password::min(8)->letters()->numbers()->symbols()],
        ]);


        $verification = (new OTPService)->verifyToken($request->{$type}, $request->token);

        if (!$verification) return error(message: 'Invalid token', statusCode: 422)->response();

        $userDetails[$type] = $request->{$type};

        $user = User::create($userDetails + [
            'name' => $request->name,
            'password' => Hash::make($request->password),
            'mobile' => $request->mobile ?? null,
            'email' => $request->email ?? null,
            'role' => $request->role ?? "staff",
        ]);

        auth()->loginUsingId($user->id);

        return success(
            'User Created Successfully',
            [
                'name' => $user->name,
                'email' => $user->email ?? null,
                'mobile' => $user->mobile ?? null,
                'token' => auth()->user()->createToken("API TOKEN")->accessToken,
            ]
        )->response();
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return success('User Logged out successfully')->response();
    }

    public function changePassword(Request $request)
    {
        validate()->make([
            'password' => ['required', 'confirmed', Password::min(8)->letters()->numbers()->symbols()],
        ]);

        $user = Auth()->user();
        $user->password = Hash::make($request->password);
        $user->save();

        return success('User password updated successfully')->response();
    }

    public function forgetPassword(Request $request, string $type)
    {
        try {
            $rules[$type] = $type == 'mobile' ? 'required|numeric|exists:users,mobile|digits_between:10,12' : 'required|string|exists:users,email|email|max:120|min:2';

            validate()->make($rules);

            $otp = (new OTPService)->sendOTP($type, $request->{$type});

            return success("OTP sent to requested $type", ['otp' => $otp])->response();
        } catch (ErrorException $e) {
            return error(message: $e->getMessage(), statusCode: $e->getCode())->response();
        }
    }

    public function resetPassword(Request $request, string $type)
    {
        $rules[$type] = $type == 'mobile' ? 'required|numeric|exists:users,mobile|digits_between:10,12' : 'required|string|exists:users,email|email|max:120|min:2';

        validate()->make($rules + [
            'token' => ['required', 'string', 'uuid'],
            'password' => ['required', 'confirmed', Password::min(8)->letters()->numbers()->symbols()]
        ]);

        $verification = (new OTPService)->verifyToken($request->{$type}, $request->token);

        if (!$verification) return error(message: 'Invalid token', statusCode: 422)->response();

        $user = User::where($type, $request->{$type})->first();

        $user = Auth::loginUsingId($user->id);
        $user->password = Hash::make($request->password);
        $user->save();

        return success('User password changed successfully', [
            'name' => $user->name,
            'email' => $user->email ?? null,
            'mobile' => $user->mobile ?? null,
            'token' => auth()->user()->createToken("API TOKEN")->accessToken,
        ])->response();
    }
}
