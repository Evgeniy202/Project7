<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('admin.user.show', compact('user'));
    }

    public function editRoleForm($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('admin.user.edit-role', compact('user', 'roles'));
    }

    public function editRole(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->syncRoles([$request->input('role')]);
        return redirect()->route('showUser', ['id' => $user->id])->with('success', 'Роль успішно змінено.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('admin')->with('success', 'Користувач успішно видалений.');
    }
    
    public function searchForm(Request $request)
    {
        $userId = $request->input('userId');
        return redirect()->route('showUser', ['id' => $userId]);
    }
}
