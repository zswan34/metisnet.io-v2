<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');
        // https://sirv.com / help / resources / users-roles-permissions /
        //  create roles / assign created permissions
        $apps = [
            'rocket.chat access',
            'FTP access',
            'S3 access',
            'pki view access'
        ];

        $permissions = [
            'add domain records',
            'edit domain records',
            'delete domain records',
            'add domain account',
            'edit domain account',
            'delete domain account',
            'purchase domain',
            'renew domain',
            'cancel domain',
            'purchase domain privacy policy',
            'remove domain privacy policy',
            'view files and folders',
            'download files and folders',
            'create folders',
            'upload files and folders',
            'move files and folders',
            'copy files and folders',
            'rename files and folders',
            'delete files and folders',
            'share folders',
            'empty trash',
            'lock and unlock folders',
            'change folder settings',
            'view usage statistics',
            'change account name',
            'edit account name',
            'transfer account ownership',
            'close account',
            'invite new user',
            'create user',
            'remove user',
            'appoint admins',
            'demote admins',
            'appoint owners',
            'demote owners',
            'view invoices',
            'change billing plan',
            'add and edit payment method',
            'add and edit billing details',
            'billing email alerts',
            'give special access',
            'remove special access',
            'issue certificates',
            'revoke certificates',
            'view certificates',
            'edit user',
            'edit account',
            'receive certificate'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
        foreach ($apps as $app)
        {
            Permission::create(['name' => $app]);
        }

        //$primary_owner = Role::create(['name' => 'primary-owner']);
        //$primary_owner->givePermissionTo(Permission::all());
        $member = Role::create([
            'name' => 'member',
            'description' => 'REDACTED'
        ]);
        $member->givePermissionTo(Permission::all()->except([
            'issue certificates', 'revoke certificates'
        ]));

        $manager = Role::create([
            'name' => 'manager',
            'description' => 'Senior managers of your team with responsibility for adding new users, 
            maintaining existing users and billing can be added as owners. Owners have almost full control over the account. 
            An account can have multiple owners.',
        ]);
        $manager->givePermissionTo(Permission::all()->except([
            'transfer account ownership', 'close account',
            'give special accesses', 'remove special accesses',
            'issue certificates', 'revoke certificates'
        ]));
        $admin = Role::create([
            'name' => 'admin',
            'description' => 'Technical administrators have complete control over the files in the account. 
            They can appoint new users and change existing user roles, except Owner roles. They cannot view or manage 
            any billing information. Admins can lock and unlock folders (Enterprise accounts only), making this a powerful role.'
        ]);
        $admin->givePermissionTo(Permission::all()->except([
            'change account name',
            'edit account name',
            'transfer account ownership',
            'close account',
            'appoint owners',
            'demote owners',
            'view invoices',
            'change billing plan',
            'add and edit payment method',
            'add and edit billing details',
            'billing email alerts',
            'give special accesses',
            'remove special accesses',
            'issue certificates',
            'revoke certificates'
        ]));

        $editor = Role::create([
            'name' => 'editor',
            'description' => 'Technical administrators have complete control over the files in the account. 
            They can appoint new users and change existing user roles, except Owner roles. They cannot view or manage 
            any billing information. Admins can lock and unlock folders (Enterprise accounts only), making this a powerful role.'
        ]);
        $editor->givePermissionTo([
            'view files and folders',
            'download files and folders',
            'create folders',
            'upload files and folders',
            'move files and folders',
            'copy files and folders',
            'rename files and folders',
            'delete files and folders',
            'share folders',
        ]);

        $contributor = Role::create([
            'name' => 'contributor',
            'description' => 'This role gives access to all the day-to-day file management operations 
            (upload, delete, rename, move and copy). Editors are unable to empty the trash, 
            so if files are deleted in error, an Owner or Admin user is able to retrieve them for 30 days. 
            If a folder has been locked, Editors and Contributors cannot delete, rename or overwrite any of its files or subfolders.'
        ]);
        $contributor->givePermissionTo([
            'view files and folders',
            'download files and folders',
            'create folders',
            'upload files and folders',
        ]);

        $viewer = Role::create([
            'name' => 'viewer',
            'description' => 'A limited role, Contributor’s can add content to your account – 
            uploading and creating new folders and files. They cannot move, copy, rename or delete any files and folders.'
        ]);
        $viewer->givePermissionTo([
            'view files and folders',
            'download files and folders',
        ]);
        $billing = Role::create([
            'name' => 'billing', 'description' => 'Ideal for finance and accounting staff, 
            this role gives complete payment and billing capability, with minimal file capability.'
        ]);
        $billing->givePermissionTo([
            'view files and folders',
            'download files and folders',
            'view invoices',
            'change billing plan',
            'add and edit payment method',
            'add and edit billing details',
            'billing email alerts'
        ]);
        $securityOfficer = Role::create([
            'name' => 'security officer', 'description' => 'This is an additional role. Security Officers can issue, 
            view, and revoke client certificates.'
        ]);
        $securityOfficer->givePermissionTo([
            'issue certificates', 'view certificates', 'revoke certificates'
        ]);
        Role::create(['name' => 'lead']);
        Role::create(['name' => 'client']);
    }
}
