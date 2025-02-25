<?php

use App\Module;
use App\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        $moduleDashboard = Module::updateOrCreate( ['name' => 'Dashboard Management'] );
        Permission::updateOrCreate( [
            'module_id' => $moduleDashboard->id,
            'name'      => 'Access Dashboard',
            'slug'      => 'dashboard',
        ] );

        /*Role module Permission*/

        $RoleModule = Module::updateOrCreate( ['name' => 'Role Management'] );
        Permission::updateOrCreate( [
            'module_id' => $RoleModule->id,
            'name'      => 'Access Role',
            'slug'      => 'roles.index',
        ] );
        Permission::updateOrCreate( [
            'module_id' => $RoleModule->id,
            'name'      => 'Create Role',
            'slug'      => 'roles.create',
        ] );
        Permission::updateOrCreate( [
            'module_id' => $RoleModule->id,
            'name'      => 'Edit Role',
            'slug'      => 'roles.edit',
        ] );
        Permission::updateOrCreate( [
            'module_id' => $RoleModule->id,
            'name'      => 'Delete Role',
            'slug'      => 'roles.destroy',
        ] );

        /*User Module Permission*/

        $UserModule = Module::updateOrCreate( ['name' => 'User Management'] );

        Permission::updateOrCreate( [
            'module_id' => $UserModule->id,
            'name'      => 'Access User',
            'slug'      => 'users.index',
        ] );
        Permission::updateOrCreate( [
            'module_id' => $UserModule->id,
            'name'      => 'Create User',
            'slug'      => 'users.create',
        ] );
        Permission::updateOrCreate( [
            'module_id' => $UserModule->id,
            'name'      => 'Edit User',
            'slug'      => 'users.edit',
        ] );
        Permission::updateOrCreate( [
            'module_id' => $UserModule->id,
            'name'      => 'Trash User',
            'slug'      => 'users.trash',
        ] );
        Permission::updateOrCreate( [
            'module_id' => $UserModule->id,
            'name'      => 'Restore User',
            'slug'      => 'users.restore',
        ] );
        Permission::updateOrCreate( [
            'module_id' => $UserModule->id,
            'name'      => 'Delete User',
            'slug'      => 'users.destroy',
        ] );


        /*Setting Module Permission*/
        $appSettingModule = Module::updateOrCreate( ['name' => 'App Setting'] );
        Permission::updateOrCreate( [
            'module_id' => $appSettingModule->id,
            'name'      => 'Access app setting module',
            'slug'      => 'app.setting.index',
        ] );
        Permission::updateOrCreate( [
            'module_id' => $appSettingModule->id,
            'name'      => 'Access Slider',
            'slug'      => 'app.slider.index',
        ] );
        Permission::updateOrCreate( [
            'module_id' => $appSettingModule->id,
            'name'      => 'Access Contact',
            'slug'      => 'app.contact.index',
        ] );
        Permission::updateOrCreate( [
            'module_id' => $appSettingModule->id,
            'name'      => 'Access Shipping',
            'slug'      => 'app.shipping.index',
        ] );
        Permission::updateOrCreate( [
            'module_id' => $appSettingModule->id,
            'name'      => 'Access Link',
            'slug'      => 'app.link.index',
        ] );
        Permission::updateOrCreate( [
            'module_id' => $appSettingModule->id,
            'name'      => 'Access Metas',
            'slug'      => 'app.meta.index',
        ] );
        Permission::updateOrCreate( [
            'module_id' => $appSettingModule->id,
            'name'      => 'Access Privacy Policies',
            'slug'      => 'app.privacy.index',
        ] );


        /*Category Module Permission*/
        $moduleCategory = Module::updateOrCreate( ['name' => 'Category Management'] );
        Permission::updateOrCreate( [
            'module_id' => $moduleCategory->id,
            'name'      => 'Access Category',
            'slug'      => 'app.category.index',
        ] );
        Permission::updateOrCreate( [
            'module_id' => $moduleCategory->id,
            'name'      => 'Approve Category',
            'slug'      => 'app.category.approve',
        ] );
        Permission::updateOrCreate( [
            'module_id' => $moduleCategory->id,
            'name'      => 'Create Category',
            'slug'      => 'app.category.create',
        ] );
        Permission::updateOrCreate( [
            'module_id' => $moduleCategory->id,
            'name'      => 'Edit Category',
            'slug'      => 'app.category.edit',
        ] );
        Permission::updateOrCreate( [
            'module_id' => $moduleCategory->id,
            'name'      => 'Delete Category',
            'slug'      => 'app.category.destroy',
        ] );

        /*Sub Category Module Permission*/
        $moduleSubCategory = Module::updateOrCreate( ['name' => 'Sub Category Management'] );
        Permission::updateOrCreate( [
            'module_id' => $moduleSubCategory->id,
            'name'      => 'Access Sub Category',
            'slug'      => 'app.subCategory.index',
        ] );
        Permission::updateOrCreate( [
            'module_id' => $moduleSubCategory->id,
            'name'      => 'Create Sub Category',
            'slug'      => 'app.subCategory.create',
        ] );
        Permission::updateOrCreate( [
            'module_id' => $moduleSubCategory->id,
            'name'      => 'Edit Sub Category',
            'slug'      => 'app.subCategory.edit',
        ] );
        Permission::updateOrCreate( [
            'module_id' => $moduleSubCategory->id,
            'name'      => 'Delete Sub Category',
            'slug'      => 'app.subCategory.destroy',
        ] );


        /*Brand Module Permission*/
        $moduleBrand = Module::updateOrCreate( ['name' => 'Brand Management'] );
        Permission::updateOrCreate( [
            'module_id' => $moduleBrand->id,
            'name'      => 'Access Brand',
            'slug'      => 'app.brand.index',
        ] );
        Permission::updateOrCreate( [
            'module_id' => $moduleBrand->id,
            'name'      => 'Create Brand',
            'slug'      => 'app.brand.create',
        ] );
        Permission::updateOrCreate( [
            'module_id' => $moduleBrand->id,
            'name'      => 'Edit Brand',
            'slug'      => 'app.brand.edit',
        ] );
        Permission::updateOrCreate( [
            'module_id' => $moduleBrand->id,
            'name'      => 'Delete Brand',
            'slug'      => 'app.brand.destroy',
        ] );


        /*Product Module Permission*/
        $moduleProduct = Module::updateOrCreate( ['name' => 'Product Management'] );
        Permission::updateOrCreate( [
            'module_id' => $moduleProduct->id,
            'name'      => 'Access Product',
            'slug'      => 'app.product.index',
        ] );
        Permission::updateOrCreate( [
            'module_id' => $moduleProduct->id,
            'name'      => 'Create Product',
            'slug'      => 'app.product.create',
        ] );
        Permission::updateOrCreate( [
            'module_id' => $moduleProduct->id,
            'name'      => 'Edit Product',
            'slug'      => 'app.product.edit',
        ] );
        Permission::updateOrCreate( [
            'module_id' => $moduleProduct->id,
            'name'      => 'Delete Product',
            'slug'      => 'app.product.destroy',
        ] );
        Permission::updateOrCreate( [
            'module_id' => $moduleProduct->id,
            'name'      => 'Flash Sale Product',
            'slug'      => 'app.product.flash',
        ] );


        /*Order Module Permission*/
        $moduleOrder = Module::updateOrCreate( ['name' => 'Order Management'] );
        Permission::updateOrCreate( [
            'module_id' => $moduleOrder->id,
            'name'      => 'Access Order',
            'slug'      => 'app.order.index',
        ] );
        Permission::updateOrCreate( [
            'module_id' => $moduleOrder->id,
            'name'      => 'Update Order',
            'slug'      => 'app.order.update',
        ] );


        /*Review Module Permission*/
        $moduleReview = Module::updateOrCreate( ['name' => 'Review Management'] );
        Permission::updateOrCreate( [
            'module_id' => $moduleReview->id,
            'name'      => 'Access Review',
            'slug'      => 'app.review.index',
        ] );
        Permission::updateOrCreate( [
            'module_id' => $moduleReview->id,
            'name'      => 'Approve Review',
            'slug'      => 'app.review.approve',
        ] );

        /*Support Module Permission*/
        $moduleSupport = Module::updateOrCreate( ['name' => 'Support Management'] );
        Permission::updateOrCreate( [
            'module_id' => $moduleSupport->id,
            'name'      => 'Access Returns',
            'slug'      => 'app.dispute.index',
        ] );
        Permission::updateOrCreate( [
            'module_id' => $moduleSupport->id,
            'name'      => 'Access Closed Returns',
            'slug'      => 'app.dispute.closed',
        ] );
        Permission::updateOrCreate( [
            'module_id' => $moduleSupport->id,
            'name'      => 'Access Ticket',
            'slug'      => 'app.ticket.index',
        ] );
        Permission::updateOrCreate( [
            'module_id' => $moduleSupport->id,
            'name'      => 'Access Closed Ticket',
            'slug'      => 'app.ticket.closed',
        ] );

        /*Coupon Module Permission*/
        $moduleCoupon = Module::updateOrCreate( ['name' => 'Coupon & Announcement'] );
        Permission::updateOrCreate( [
            'module_id' => $moduleCoupon->id,
            'name'      => 'Access Coupon',
            'slug'      => 'app.coupon.index',
        ] );
        Permission::updateOrCreate( [
            'module_id' => $moduleCoupon->id,
            'name'      => 'Access Announcement',
            'slug'      => 'app.offer.index',
        ] );




        /*Other Module Permission*/
        $moduleOther = Module::updateOrCreate( ['name' => 'Other Module Management'] );
        Permission::updateOrCreate( [
            'module_id' => $moduleOther->id,
            'name'      => 'Access Search',
            'slug'      => 'app.search.index',
        ] );
        Permission::updateOrCreate( [
            'module_id' => $moduleOther->id,
            'name'      => 'Access Click',
            'slug'      => 'app.click.index',
        ] );
        Permission::updateOrCreate( [
            'module_id' => $moduleOther->id,
            'name'      => 'Access Customer',
            'slug'      => 'app.customer.index',
        ] );
        Permission::updateOrCreate( [
            'module_id' => $moduleOther->id,
            'name'      => 'Access Subscriber',
            'slug'      => 'app.subscriber.index',
        ] );
        Permission::updateOrCreate( [
            'module_id' => $moduleOther->id,
            'name'      => 'Access Report',
            'slug'      => 'app.report.index',
        ] );

    }
}
