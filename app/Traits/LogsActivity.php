<?php

namespace App\Traits;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;

trait LogsActivity
{
    /**
     * Log an action to the audit log
     */
    public function logActivity(
        string $action, 
        $model = null, 
        ?string $description = null, 
        array $oldValues = [], 
        array $newValues = []
    ) {
        $logData = [
            'user_id' => auth()->id(),
            'action' => $action,
            'description' => $description ?? $this->generateDescription($action, $model),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ];

        if ($model) {
            $logData['model_type'] = get_class($model);
            $logData['model_id'] = $model->id;
            
            // For updates, track what changed
            if ($action === 'UPDATE' && !empty($oldValues)) {
                $logData['old_values'] = json_encode($oldValues);
                $logData['new_values'] = json_encode($newValues);
            }
            
            // For archive/restore operations
            if (in_array($action, ['ARCHIVE', 'RESTORE', 'DELETE_PERMANENT'])) {
                $logData['old_values'] = json_encode(['is_archived' => $model->is_archived]);
                $logData['new_values'] = json_encode([
                    'is_archived' => $action === 'ARCHIVE' ? true : ($action === 'RESTORE' ? false : null)
                ]);
            }
        }

        return AuditLog::create($logData);
    }

    /**
     * Generate a human-readable description
     */
    protected function generateDescription($action, $model = null)
    {
        $userName = auth()->user()?->first_name . ' ' . auth()->user()?->last_name ?? 'System';
        
        if (!$model) {
            return match($action) {
                'LOGIN' => "{$userName} logged in",
                'REGISTER' => "{$userName} registered to the system.",
                'LOGOUT' => "{$userName} logged out",
                'LOGIN_FAILED' => "Failed login attempt for " . request()->input('email'),
                'EXPORT' => "{$userName} exported data",
                'EXPORT_EVENTS' => "{$userName} exported events data",
                'EXPORT_REGISTRATIONS' => "{$userName} exported registrations data",
                'EXPORT_PAYMENTS' => "{$userName} exported payments data",
                'EXPORT_ARCHIVED' => "{$userName} exported archived events data",
                default => "{$userName} performed {$action}",
            };
        }

        $modelName = class_basename($model);
        $modelIdentifier = $model->title ?? $model->name ?? $model->first_name ?? "ID: {$model->id}";

        return match($action) {
            'CREATE' => "{$userName} created {$modelName}: {$modelIdentifier}",
            'UPDATE' => "{$userName} updated {$modelName}: {$modelIdentifier}",
            'DELETE' => "{$userName} deleted {$modelName}: {$modelIdentifier}",
            'DELETE_PERMANENT' => "{$userName} permanently deleted {$modelName}: {$modelIdentifier}",
            'VIEW' => "{$userName} viewed {$modelName}: {$modelIdentifier}",
            'ARCHIVE' => "{$userName} archived {$modelName}: {$modelIdentifier}",
            'RESTORE' => "{$userName} restored {$modelName}: {$modelIdentifier}",
            'EXPORT' => "{$userName} exported {$modelName} data",
            'VERIFY_PAYMENT' => "{$userName} verified payment for {$modelName}: {$modelIdentifier}",
            'REJECT_PAYMENT' => "{$userName} rejected payment for {$modelName}: {$modelIdentifier}",
            'RESET_PAYMENT' => "{$userName} reset payment status for {$modelName}: {$modelIdentifier}",
            'GENERATE_TICKET' => "{$userName} generated ticket for {$modelName}: {$modelIdentifier}",
            'REGENERATE_TICKET' => "{$userName} regenerated ticket for {$modelName}: {$modelIdentifier}",
            'REGISTER_EVENT' => "{$userName} registered for event: {$modelIdentifier}",
            'CANCEL_REGISTRATION' => "{$userName} cancelled registration for event: {$modelIdentifier}",
            default => "{$userName} {$action} {$modelName}: {$modelIdentifier}",
        };
    }
}