<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\SearchUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\User\UserListResource;
use App\Http\Resources\User\UserShowResource;
use Symfony\Component\HttpFoundation\Response;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        $this->checkGate('user_access');

        return UserListResource::collection($request->per_page ? User::with(['roles'])->paginate($request->per_page) : User::with(['roles'])->get());
    }

    public function search(SearchUserRequest $request)
    {
        $periode = $request->periode;
        $email = $request->email;
        $telephone = $request->telephone;
        $nom = $request->nom;
        $prenom = $request->prenom;
        $fullname = $request->fullname;
        $role_ids = $request->role_ids;
        $roles = $request->roles;
        $per_page = $request->per_page ?? 10;


        $users = User::query()->with(['roles']);

        if($periode)
        {
            $from = new Carbon($periode['from']);
            $to = new Carbon($periode['to']);

            if($from)
            {
                $users = $users->where('created_at', '>=', $from);
            }

            if($to)
            {
                $users = $users->where('created_at', '<=', $to);
            }
        }

        if($email)
        {
            $users = $users->where('email', 'LIKE', '%'.$email.'%');
        }

        if($telephone)
        {
            $users = $users->where('telephone', 'LIKE', '%'.$telephone.'%');
        }

        if($nom)
        {
            $users = $users->where('nom', 'LIKE', '%'.$nom.'%');
        }

        if($prenom)
        {
            $users = $users->where('prenom', 'LIKE', '%'.$prenom.'%');
        }

        if($fullname)
        {
            $users = $users->orWhere('prenom', 'LIKE', '%'.$prenom.'%')->where('prenom', 'LIKE', '%'.$prenom.'%');
        }

        if($roles)
        {
            $users = $users->whereHas('roles', function($role_item) use (&$roles)
            {
                $role_item->whereIn('alias', $roles);
            });
        }

        if($role_ids)
        {
            $users = $users->whereHas('roles', function($role) use (&$role_ids)
            {
                $role->whereIn('id', $role_ids);
            });
        }

        return UserListResource::collection($users->orderByDesc('created_at')->paginate($per_page));

    }

    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->all());

        if($request->roles)
        {
            $roles = Role::whereIn('alias', $request->roles)->pluck('id');

            $user->roles()->syncWithoutDetaching($roles);
        }

        if($request->avatar)
        {
            $user->clearMediaCollection(User::AVATAR_COLLECTION_NAME);
            $user->addMedia($request->avatar)->toMediaCollection(User::AVATAR_COLLECTION_NAME);
        }

        //Handle User created actions

        return (new UserListResource($user))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(User $user)
    {
        $this->checkGate('user_show');

        return new UserShowResource($user->load('roles'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->all());

        if($request->roles)
        {
            $user->roles()->detach();

            $roles = Role::whereIn('alias', $request->roles)->pluck('id');

            $user->roles()->syncWithoutDetaching($roles);
        }

        if($request->avatar)
        {
            $user->clearMediaCollection(User::AVATAR_COLLECTION_NAME);
            $user->addMedia($request->avatar)->toMediaCollection(User::AVATAR_COLLECTION_NAME);
        }

        return (new UserListResource($user))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(User $user)
    {
        $this->checkGate('user_delete');

        $user->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
