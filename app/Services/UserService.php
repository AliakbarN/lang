<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserWord;

final class UserService
{

    protected Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function all() :\Illuminate\Database\Eloquent\Collection
    {
        return User::all();
    }

    public function getById() :mixed
    {
        $user = User::find($this->request['userId']);

        if (!$user) {
            return false;
        }

        return $user;
    }

    public function save() :bool
    {
        $data = $this->request['parsedData'];

        $user = new User($data);

        $isUserSaved = $user->save();

        if (!$isUserSaved) {
            return false;
        }

        (new UserWord())->save();

        return true;
    }

    public function update() :bool
    {
        $user = User::find($this->request['userId']);

        if (!$user) {
            return false;
        }

        return $user->update($this->request['parsedData']);
    }

    public function delete() :bool
    {
        $user = User::find($this->request['userId']);

        if (!$user) {
            return false;
        }

        return $user->delete();
    }
}