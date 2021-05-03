<?php

namespace Thotam\ThotamBuddy\Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Thotam\ThotamBuddy\Models\BuddyTrangThai;

class Buddy_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //BuddyTrangThai Seed
        BuddyTrangThai::updateOrCreate(
            ['id' => 1],
            [
                'trangthai' => "Đã hủy",
                'active' => true
            ]
        );

        BuddyTrangThai::updateOrCreate(
            ['id' => 5],
            [
                'trangthai' => "Mới tạo",
                'active' => true
            ]
        );

        BuddyTrangThai::updateOrCreate(
            ['id' => 7],
            [
                'trangthai' => "Không duyệt Buddy",
                'active' => true
            ]
        );

        BuddyTrangThai::updateOrCreate(
            ['id' => 9],
            [
                'trangthai' => "Đã phân công",
                'active' => true
            ]
        );

        BuddyTrangThai::updateOrCreate(
            ['id' => 11],
            [
                'trangthai' => "Đang lên tiêu chí",
                'active' => true
            ]
        );

        BuddyTrangThai::updateOrCreate(
            ['id' => 13],
            [
                'trangthai' => "Đã lên tiêu chí",
                'active' => true
            ]
        );

        BuddyTrangThai::updateOrCreate(
            ['id' => 15],
            [
                'trangthai' => "Không duyệt tiêu chí",
                'active' => true
            ]
        );

        BuddyTrangThai::updateOrCreate(
            ['id' => 17],
            [
                'trangthai' => "Đã duyệt tiêu chí",
                'active' => true
            ]
        );

        BuddyTrangThai::updateOrCreate(
            ['id' => 19],
            [
                'trangthai' => "Đang thực hiện",
                'active' => true
            ]
        );

        BuddyTrangThai::updateOrCreate(
            ['id' => 21],
            [
                'trangthai' => "Đã báo cáo",
                'active' => true
            ]
        );

        BuddyTrangThai::updateOrCreate(
            ['id' => 23],
            [
                'trangthai' => "Đã thực hiện",
                'active' => true
            ]
        );

        BuddyTrangThai::updateOrCreate(
            ['id' => 25],
            [
                'trangthai' => "Không đạt",
                'active' => true
            ]
        );

        BuddyTrangThai::updateOrCreate(
            ['id' => 27],
            [
                'trangthai' => "Đạt",
                'active' => true
            ]
        );

        //Role and Permission
        $permission[] = Permission::updateOrCreate([
            'name' => 'view-buddy'
        ],[
            "description" => "Xem Buddy",
            "group" => "Buddy",
            "order" => 1,
            "lock" => true,
        ]);

        $permission[] = Permission::updateOrCreate([
            'name' => 'add-buddy'
        ],[
            "description" => "Thêm Buddy",
            "group" => "Buddy",
            "order" => 2,
            "lock" => true,
        ]);

        $permission[] = Permission::updateOrCreate([
            'name' => 'edit-buddy'
        ],[
            "description" => "Sửa Buddy",
            "group" => "Buddy",
            "order" => 3,
            "lock" => true,
        ]);

        $permission[] = Permission::updateOrCreate([
            'name' => 'delete-buddy'
        ],[
            "description" => "Xóa Buddy",
            "group" => "Buddy",
            "order" => 4,
            "lock" => true,
        ]);

        $permission[] = Permission::updateOrCreate([
            'name' => 'duyet-buddy'
        ],[
            "description" => "Duyệt Buddy",
            "group" => "Buddy",
            "order" => 5,
            "lock" => true,
        ]);

        $super_admin = Role::updateOrCreate([
            'name' => 'super-admin'
        ],[
            "description" => "Super Admin",
            "group" => "Admin",
            "order" => 1,
            "lock" => true,
        ]);

        $admin = Role::updateOrCreate([
            'name' => 'admin'
        ],[
            "description" => "Admin",
            "group" => "Admin",
            "order" => 2,
            "lock" => true,
        ]);

        $admin_buddy = Role::updateOrCreate([
            'name' => 'admin-buddy'
        ],[
            "description" => "Admin Buddy",
            "group" => "Admin",
            "order" => 6,
            "lock" => true,
        ]);

        $super_admin->givePermissionTo($permission);
        $admin->givePermissionTo($permission);
        $admin_buddy->givePermissionTo($permission);

    }
}
