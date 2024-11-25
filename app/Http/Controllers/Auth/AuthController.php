<?php

namespace App\Http\Controllers\Auth;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Login;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\User\UserShortResource;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Auth\ChangePasswordRequest;

class AuthController extends Controller
{
    public function register(RegisterRequest $request) : JsonResponse
    {
        $user = User::create($request->all());

        $user->roles()->attach(Role::where('alias', Role::ADMIN_ROLE_ALIAS)->first()->id);

        if($request->avatar)
        {
            $user->addMedia($request->avatar)->toMediaCollection(User::AVATAR_COLLECTION_NAME);
        }

        event(new Registered($user));

        return $this->handleResponse($user, trans('auth.registered'), Response::HTTP_CREATED);
    }

    public function login(LoginRequest $request) : JsonResponse
    {

        if(Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
        ]))
        {
            // $user = User::where('email', $request->email)->first();

            $user = User::find(Auth::user()->id);

            $data["token"] = $user->createToken("CINEMA AUTH TOKEN")->plainTextToken;

            $data['user'] = new UserShortResource($user->load('roles'));

            return $this->handleResponse($data, trans('auth.login'));

        }else{

            return $this->handleResponse([], trans('auth.failed'), Response::HTTP_UNAUTHORIZED, false);
        }

    }

    public function logout() : JsonResponse
    {
        Auth::logout();

        return $this->handleResponse(null, trans('auth.logout'));
    }

    public function change_password(ChangePasswordRequest $request)
    {
        $user = User::find(auth()->user()->id);

        if(Hash::check($request->old_password, $user->password))
        {
            if(Hash::check($request->password, $user->password))
            {

                return $this->handleResponse([], trans('passwords.must_not_match'), 422, false);

            }
            $user->update(['password' => $request->password]);

            return $this->handleResponse([], trans('passwords.changed'));
        }
        return $this->handleResponse([],trans('auth.failed'), Response::HTTP_UNPROCESSABLE_ENTITY, false);
    }

}
