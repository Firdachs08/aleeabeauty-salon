<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $users = User::query()
            ->where('username', 'LIKE', "%{$search}%")
            ->orWhere('email', 'LIKE', "%{$search}%")
            ->orWhere('phone', 'LIKE', "%{$search}%")
            ->paginate(10);
        return view('admin.users.index', compact('users'));
    }
    

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(StoreUserRequest $request)
{
    $data = $request->validated();
    $data['password'] = bcrypt($data['password']);
    User::create($data);

    return redirect()->route('admin.users.index')->with('message', "Successfully Created!");
}


    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request, $id)
{
    $user = User::findOrFail($id);
    $data = $request->validated();

    if ($request->filled('password')) {
        $data['password'] = bcrypt($data['password']);
    } else {
        unset($data['password']);
    }

    $user->update($data);

    return redirect()->route('admin.users.index')->with('message', "Successfully Updated!");
}

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index')->with('message', 'User successfully deleted.');
    }
}
