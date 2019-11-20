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
            [
                'name' => 'add domain records',
                'category' => 'domain'
            ], [
                'name' => 'edit domain records',
                'category' => 'domain'
            ], [
                'name' => 'delete domain records',
                'category' => 'domain'
            ], [
                'name' => 'add domain account',
                'category' => 'domain'
            ], [
                'name' => 'edit domain account',
                'category' => 'domain'
            ], [
                'name' => 'delete domain account',
                'category' => 'domain'
            ], [
                'name' => 'purchase domain',
                'category' => 'domain'
            ], [
                'name' => 'renew domain',
                'category' => 'domain'
            ], [
                'name' => 'cancel domain',
                'category' => 'domain'
            ], [
                'name' => 'purchase domain privacy policy',
                'category' => 'domain'
            ], [
                'name' => 'remove domain privacy policy',
                'category' => 'domain'
            ], [
                'name' => 'view files and folders',
                'category' => 'files and folders'
            ], [
                'name' => 'download files and folders',
                'category' => 'files and folders'
            ], [
                'name' => 'create folders',
                'category' => 'files and folders'
            ], [
                'name' => 'upload files and folders',
                'category' => 'files and folders'
            ], [
                'name' => 'move files and folders',
                'category' => 'files and folders'
            ], [
                'name' => 'copy files and folders',
                'category' => 'files and folders'
            ], [
                'name' => 'rename files and folders',
                'category' => 'files and folders'
            ], [
                'name' => 'delete files and folders',
                'category' => 'files and folders'
            ], [
                'name' => 'share folders',
                'category' => 'files and folders'
            ], [
                'name' => 'empty trash',
                'category' => 'files and folders'
            ], [
                'name' => 'lock and unlock folders',
                'category' => 'files and folders'
            ], [
                'name' => 'change folder settings',
                'category' => 'files and folders'
            ], [
                'name' => 'view usage statistics',
                'category' => 'systems'
            ], [
                'name' => 'change account name',
                'category' => 'accounts'
            ], [
                'name' => 'edit account name',
                'category' => 'accounts'
            ], [
                'name' => 'transfer account ownership',
                'category' => 'accounts'
            ], [
                'name' => 'close account',
                'category' => 'accounts'
            ], [
                'name' => 'invite new user',
                'category' => 'users'
            ], [
                'name' => 'create user',
                'category' => 'users'
            ], [
                'name' => 'remove user',
                'category' => 'users'
            ], [
                'name' => 'appoint admins',
                'category' => 'users'
            ], [
                'name' => 'demote admins',
                'category' => 'users'
            ], [
                'name' => 'appoint owners',
                'category' => 'users'
            ], [
                'name' => 'demote owners',
                'category' => 'users'
            ], [
                'name' => 'view invoices',
                'category' => 'billing'
            ], [
                'name' => 'change billing plan',
                'category' => 'billing'
            ], [
                'name' => 'add and edit payment method',
                'category' => 'billing'
            ], [
                'name' => 'add and edit billing details',
                'category' => 'billing'
            ], [
                'name' => 'billing email alerts',
                'category' => 'billing'
            ], [
                'name' => 'give special access',
                'category' => 'access'
            ], [
                'name' => 'remove special access',
                'category' => 'access'
            ], [
                'name' => 'issue certificates',
                'category' => 'security'
            ], [
                'name' => 'revoke certificates',
                'category' => 'security'
            ], [
                'name' => 'view certificates',
                'category' => 'security'
            ], [
                'name' => 'edit user',
                'category' => 'users'
            ], [
                'name' => 'edit account',
                'category' => 'accounts'
            ], [
                'name' => 'receive certificate',
                'category' => 'security'
            ]
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
        foreach ($apps as $app)
        {
            Permission::create(['name' => $app, 'category' => 'extras']);
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
