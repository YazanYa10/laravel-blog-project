<?php

if (!function_exists('formatAuditLog')) {
    function formatAuditLog($log)
    {
        switch ($log->description) {
            case 'User created':
            case 'User archived':
            case 'User restored':
            case 'User permanently deleted':
                $role = implode(', ', $log->properties['role']);
                return "<strong>Name:</strong> {$log->properties['name']}<br><strong>Role:</strong> {$role}";

            case 'User roles updated':
                $name = $log->properties['name'] ?? '';
                $oldRoles = implode(', ', $log->properties['old_roles'] ?? []);
                $newRoles = implode(', ', $log->properties['new_roles'] ?? []);
                return "<strong>Name :</strong> {$name}<strong><br>Old Roles:</strong> {$oldRoles}<br><strong>New Roles:</strong> {$newRoles}";
            case 'User name updated':
                $oldname = $log->properties['old_name'] ?? '';
                $newname = $log->properties['new_name'] ?? '';
                $role = implode(', ', $log->properties['role'] ?? []);
                return "<strong>Old Name :</strong> {$oldname}<strong><br>New Name:</strong> {$newname}<br><strong>Roles:</strong> {$role}";
            case 'User password updated':
                return "<strong>Password:</strong> {$log->properties['password']}";
            default:
                return "No structured data available.";
        }
    }
}
if (!function_exists('formatRoleLog')) {
    function formatRoleLog($log)
    {
        switch ($log->description) {
            case 'Role created':
            case 'Role deleted': 
                return "<strong>Role:</strong> {$log->properties['name']}<br>" .
                    "<strong>Permissions:</strong> " . implode(', ', $log->properties['permissions'] ?? []);
            case 'Role name updated':
                $oldname = $log->properties['old_name'] ?? '';
                $newname = $log->properties['new_name'] ?? '';
                return "<strong>Old Name:</strong> {$oldname}<br>" .
                       "<strong>New Name:</strong> {$newname}<br>" .
                    "<strong>Permissions:</strong> " . implode(', ', $log->properties['permissions'] ?? []);
            case 'Role permissions updated':
                return "<strong>Role:</strong> {$log->properties['name']}<br>" .
                    "<strong>Old Permissions:</strong> " . implode(', ', $log->properties['old_permissions'] ?? []) . "<br>" .
                    "<strong>New Permissions:</strong> " . implode(', ', $log->properties['new_permissions'] ?? []);

            default:
                return "No structured data available.";
        }
    }
}