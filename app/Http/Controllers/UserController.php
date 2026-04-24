<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class UserController extends Controller
{
    public function index()
    {
        abort_if(!auth()->user()->hasRole('Super-administrateur'), 403);

        $users = User::with('roles')->get()->map(fn($u) => [
            'id'         => $u->id_user,
            'lastname'   => $u->lastname,
            'firstname'  => $u->firstname,
            'sex'        => $u->sex,
            'email'      => $u->email,
            'roles'      => $u->roles->map(fn($r) => ['id' => $r->id, 'name' => $r->name])->values(),
            'created_at' => $u->created_at?->format('d/m/Y'),
        ]);

        // User count per role (avoids N+1)
        $roleCounts = DB::table('model_has_roles')
            ->where('model_type', User::class)
            ->selectRaw('role_id, count(*) as cnt')
            ->groupBy('role_id')
            ->pluck('cnt', 'role_id');

        $roles = Role::with('permissions')->get()->map(fn($r) => [
            'id'          => $r->id,
            'name'        => $r->name,
            'permissions' => $r->permissions->pluck('name')->values(),
            'users_count' => (int) ($roleCounts[$r->id] ?? 0),
        ])->values();

        $permissions = Permission::all()->map(fn($p) => [
            'id'   => $p->id,
            'name' => $p->name,
        ])->values();

        return Inertia::render('Users/Index.users', [
            'allUsers'       => $users,
            'allRoles'       => $roles,
            'allPermissions' => $permissions,
        ]);
    }

    // ── User CRUD ────────────────────────────────────────────────

    public function store(Request $request)
    {
        abort_if(!auth()->user()->hasRole('Super-administrateur'), 403);

        $request->validate([
            'lastname'  => 'required|string|min:2',
            'firstname' => 'required|string|min:2',
            'sex'       => 'required|in:M,F',
            'roles'     => 'nullable|array',
            'roles.*'   => 'string|exists:roles,name',
        ], [
            'lastname.required'  => 'Le nom est obligatoire.',
            'firstname.required' => 'Le prénom est obligatoire.',
            'sex.required'       => 'Le sexe est obligatoire.',
        ]);

        $email = $this->generateEmail($request->firstname, $request->lastname);

        $user = User::create([
            'lastname'  => $request->lastname,
            'firstname' => $request->firstname,
            'sex'       => $request->sex,
            'email'     => $email,
            'password'  => Hash::make('password'),
        ]);

        if ($request->roles) {
            $user->syncRoles($request->roles);
        }

        return redirect()->route('users')->with([
            'message' => "Utilisateur créé ! Login : {$email} — Mot de passe provisoire : password",
            'type'    => 'success',
        ]);
    }

    public function update(Request $request, $id)
    {
        abort_if(!auth()->user()->hasRole('Super-administrateur'), 403);

        $user = User::findOrFail($id);

        $request->validate([
            'lastname'  => 'required|string|min:2',
            'firstname' => 'required|string|min:2',
            'sex'       => 'required|in:M,F',
            'password'  => 'nullable|string|min:8',
            'roles'     => 'nullable|array',
            'roles.*'   => 'string|exists:roles,name',
        ], [
            'lastname.required'  => 'Le nom est obligatoire.',
            'firstname.required' => 'Le prénom est obligatoire.',
            'sex.required'       => 'Le sexe est obligatoire.',
            'password.min'       => 'Le mot de passe doit contenir au moins 8 caractères.',
        ]);

        $user->update([
            'lastname'  => $request->lastname,
            'firstname' => $request->firstname,
            'sex'       => $request->sex,
        ]);

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        if ($request->has('roles')) {
            $user->syncRoles($request->roles ?? []);
        }

        return redirect()->route('users')->with([
            'message' => 'Utilisateur modifié avec succès !',
            'type'    => 'success',
        ]);
    }

    public function destroy($id)
    {
        abort_if(!auth()->user()->hasRole('Super-administrateur'), 403);

        $user = User::findOrFail($id);

        if ($user->id_user === auth()->id()) {
            return redirect()->route('users')->with([
                'message' => 'Impossible de supprimer votre propre compte.',
                'type'    => 'error',
            ]);
        }

        $user->delete();

        return redirect()->route('users')->with([
            'message' => 'Utilisateur supprimé avec succès !',
            'type'    => 'success',
        ]);
    }

    // ── Role CRUD ────────────────────────────────────────────────

    public function storeRole(Request $request)
    {
        abort_if(!auth()->user()->hasRole('Super-administrateur'), 403);

        $request->validate([
            'name'          => 'required|string|min:2|unique:roles,name',
            'permissions'   => 'nullable|array',
            'permissions.*' => 'string|exists:permissions,name',
        ], [
            'name.required' => 'Le nom du rôle est obligatoire.',
            'name.unique'   => 'Ce nom de rôle existe déjà.',
            'name.min'      => 'Minimum 2 caractères.',
        ]);

        $role = Role::create(['name' => $request->name, 'guard_name' => 'web']);

        if ($request->permissions) {
            $role->syncPermissions($request->permissions);
        }

        app(PermissionRegistrar::class)->forgetCachedPermissions();

        return redirect()->route('users')->with([
            'message' => "Rôle « {$request->name} » créé avec succès !",
            'type'    => 'success',
        ]);
    }

    public function updateRole(Request $request, $id)
    {
        abort_if(!auth()->user()->hasRole('Super-administrateur'), 403);

        $role = Role::findOrFail($id);

        $request->validate([
            'name'          => "required|string|min:2|unique:roles,name,{$id}",
            'permissions'   => 'nullable|array',
            'permissions.*' => 'string|exists:permissions,name',
        ], [
            'name.required' => 'Le nom du rôle est obligatoire.',
            'name.unique'   => 'Ce nom de rôle existe déjà.',
        ]);

        $role->update(['name' => $request->name]);
        $role->syncPermissions($request->permissions ?? []);

        app(PermissionRegistrar::class)->forgetCachedPermissions();

        return redirect()->route('users')->with([
            'message' => 'Rôle modifié avec succès !',
            'type'    => 'success',
        ]);
    }

    public function destroyRole($id)
    {
        abort_if(!auth()->user()->hasRole('Super-administrateur'), 403);

        $role = Role::findOrFail($id);

        if ($role->name === 'Super-administrateur') {
            return redirect()->route('users')->with([
                'message' => 'Le rôle Super-administrateur ne peut pas être supprimé.',
                'type'    => 'error',
            ]);
        }

        $role->delete();

        app(PermissionRegistrar::class)->forgetCachedPermissions();

        return redirect()->route('users')->with([
            'message' => 'Rôle supprimé avec succès !',
            'type'    => 'success',
        ]);
    }

    // ── Helpers ──────────────────────────────────────────────────

    private function generateEmail(string $firstname, string $lastname): string
    {
        $map = [
            'à'=>'a','â'=>'a','ä'=>'a','é'=>'e','è'=>'e','ê'=>'e','ë'=>'e',
            'î'=>'i','ï'=>'i','ô'=>'o','ö'=>'o','ù'=>'u','û'=>'u','ü'=>'u','ç'=>'c',
            'À'=>'a','Â'=>'a','Ä'=>'a','É'=>'e','È'=>'e','Ê'=>'e','Ë'=>'e',
            'Î'=>'i','Ï'=>'i','Ô'=>'o','Ö'=>'o','Ù'=>'u','Û'=>'u','Ü'=>'u','Ç'=>'c',
        ];
        $clean = fn($s) => preg_replace('/[^a-z0-9]/', '', strtolower(strtr($s, $map)));
        $base  = $clean($firstname) . '.' . $clean($lastname);
        $email = $base . '@synetcom-niger.com';

        $counter = 1;
        while (User::where('email', $email)->exists()) {
            $email = $base . $counter . '@synetcom-niger.com';
            $counter++;
        }

        return $email;
    }
}
