<?php

use App\Permission;
use App\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $adminPersmissions = Permission::all();
        Role::updateOrCreate( [
            'name'      => 'Super Admin',
            'slug'      => 'super-admin',
            'deletable' => false,
        ] )->permissions()->sync( $adminPersmissions->pluck( 'id' ) );
    }
}
