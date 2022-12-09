<?php

namespace App\Http\Controllers\Api\Admin\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\V1\Users\storeUsersRequest;
use App\Http\Requests\Admin\V1\Users\updateUsersRequest;
use App\Http\Resources\Api\admin\v1\usersCollection;
use App\Http\Resources\Api\admin\v1\usersResource;
use App\Http\Traits\HttpResponse;
use App\Models\User;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Hash;

class usersController extends Controller
{
    use HttpResponse;

    /**
     * Display a listing of the resource.
     *
     * @return usersCollection
     */
    public function index(HttpRequest $req)
    {
        return new usersCollection(User::paginate($this->paginateCnt($req->input('cnt'))));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(storeUsersRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return $this->success(new usersResource($user), 'User created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @return usersResource
     */
    public function show(User $user)
    {
        return new usersResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(updateUsersRequest $request, User $user)
    {
        $data = $request->all();
        if ($request->has('password')) {
            $data['password'] = Hash::make($data['password']);
        }
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->has('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->update();

        return $this->success(new usersResource($user), 'Update updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(User $user)
    {
        $user->delete();

        return $this->success('User deleted successfully');
    }

    private function paginateCnt(int|null $cnt)
    {
        if ($cnt) {
            if (is_numeric($cnt) && $cnt >= 5 && $cnt <= 50) {
                return $cnt;
            }
        }

        return 10;
    }
}