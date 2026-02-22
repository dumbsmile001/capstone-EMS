<?php

namespace App\Traits;

use App\Models\AuditLog;

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
                $logData['old_values'] = $oldValues;
                $logData['new_values'] = $newValues;
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
                default => "{$userName} performed {$action}",
            };
        }

        $modelName = class_basename($model);
        $modelIdentifier = $model->title ?? $model->name ?? $model->first_name ?? "ID: {$model->id}";

        return match($action) {
            'CREATE' => "{$userName} created {$modelName}: {$modelIdentifier}",
            'UPDATE' => "{$userName} updated {$modelName}: {$modelIdentifier}",
            'DELETE' => "{$userName} deleted {$modelName}: {$modelIdentifier}",
            'VIEW' => "{$userName} viewed {$modelName}: {$modelIdentifier}",
            default => "{$userName} {$action} {$modelName}: {$modelIdentifier}",
        };
    }
}