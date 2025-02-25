<?php

namespace App\Http\Middleware;

use App\Role;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AuthGates
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $user = Auth::user();
        if ( $user ) {
            $roles = Role::with( 'permissions' )->get();

            $permissionsArray = [];

            foreach ( $roles as $role ) {
                foreach ( $role->permissions as $permissions ) {
                    $permissionsArray[$permissions->slug][] = $role->id;
                }
            }
            foreach ($permissionsArray as $slug => $roles) {
                Gate::define($slug, function ($user) use ($roles) {
                    return count(array_intersect($user->roles->pluck('id')->toArray(), $roles)) > 0;
                });
            }
        }
        return $next( $request );
    }
}
