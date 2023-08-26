<?php

namespace App\UseCases\UserAction;

use App\Helpers\FilterSearchHelper;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Models\UserLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;
use Illuminate\Pagination\LengthAwarePaginator;

class UserAction
{
    public function fetchUsers(): LengthAwarePaginator
    {
        $limit = request()->limit ?? 6;
        $page = request()->page ?? 1;
        $data = FilterSearchHelper::userFilter()
            ->orderBy('created_at', 'desc')
            ->paginate($limit, ['*'], 'page', $page)
            ->withQueryString();

        return $data;
    }

    public function createUser(array $data): User
    {
        DB::beginTransaction();
        try {
            $data['password'] = Hash::make($data['password']);
            $user = User::create($data);
            DB::commit();
            return $user;
        } catch (QueryException $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }

    public function updateUser(UserRequest $request, User $user): int
    {
        DB::beginTransaction();
        try {
            $hashedPassword = Hash::make($request->password);
            $user->password = $hashedPassword;
            $user->account_status = $request->accountStatus;
            $user->update($request->except(['password']));
            DB::commit();
            return 200;
        } catch (QueryException $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }

    public function deleteUser(User $user): int
    {
        try {
            $user->delete();
            return 200;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function saveLocation(Request $req): int
    {
        DB::beginTransaction();
        try {
            $saveLocation = new UserLocation();
            $saveLocation->latitude = $req->latitude;
            $saveLocation->longitude = $req->longitude;
            $saveLocation->save();
            DB::commit();
            return 200;
        } catch (QueryException $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }

    public function searchUser(string $searchUser): User
    {
        $result = User::where();

        return $result;
    }
}
