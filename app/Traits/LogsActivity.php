<?php


namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

trait LogsActivity
{
    // ─────────────────────────────────────────────────────────────
        // Author : Ahsan Danish | ahsandanish.rad@gmail.com
        // GitHub : github.com/carlosbrath | LinkedIn: linkedin.com/in/ahsandanishrad/
        // Note   : Module created/updated by Ahsan Danish
    // ─────────────────────────────────────────────────────────────
    protected static $ignoreFields = ['last_login_at', 'updated_at', 'lastActivity'];
    public static function bootLogsActivity()
    {
        
        static::created(function ($model) {
            $model->logActivity('create');
        });

        static::updated(function ($model) {
            $model->logActivity('update');
        });

        static::deleted(function ($model) {
            $model->logActivity('delete');
        });
    }

    public function logActivity($action)
    {
        $changes = null;

        if ($action === 'update') {

            $original = $this->getOriginal();
            $changed = $this->getChanges();

            // Remove ignored fields
            foreach (self::$ignoreFields as $field) {
                unset($original[$field], $changed[$field]);
            }
            if (empty($changed)) {
                return;
            }
            $changes = [
                'before' => array_intersect_key($original, $changed),
                'after' => $this->getChanges(),
            ];
        }

        // Determine actor (user, applicant, or system)
        $performedBy = null;
        $user_id   = null;

        if (Auth::check()) {
            $performedBy = 'user';
            $user_id   = Auth::id();
        } elseif (request()->has('applicant_id')) {
            $performedBy = 'applicant';
            $user_id   = request()->get('applicant_id');
        } else {
            $performedBy = 'system'; // e.g. cron job or guest action
            $user_id   = null;
        }

        // Collect meta info
        $meta = [
            'ip'         => request()->ip(),
            'user_agent' => request()->userAgent(),
            'url'        => request()->fullUrl(),
            'method'     => request()->method(),
        ];

        ActivityLog::create([
            'model'      => class_basename($this),
            'model_id'   => $this->id,
            'action'     => $action,
            'changes'    => $changes ? json_encode($changes) : null,
            'performed_by' => $performedBy,
            'user_id'   => $user_id,
            'meta_info'  => json_encode($meta),
        ]);
    }
}
