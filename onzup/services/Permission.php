<?php

namespace Onzup\Services;

/**
 * This class is onzup service for Permissions.
 */
class Permission
{
    private $modules = [
        'users' => [
            'users.create',
            'users.update',
            'users.view',
            'users.profile_view',
            'users.delete',
            'users.activeDeactive',
        ],
        'roles' => [
            'roles.create',
            'roles.view',
            'roles.update',
            'roles.delete',
        ],
        'settings' => [
            'settings.view',
        ],
        'currency' => [
            'currency.create',
            'currency.view',
            'currency.update',
            'currency.delete',
        ],       
        /* don't remove this */
    ];

    public function getPermissions()
    {
        return $this->modules;
    }
}
