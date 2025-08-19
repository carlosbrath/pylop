<?php

namespace App\Traits;

use App\Models\ApplicantStatusLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

trait HasStatusTracking
{
    /**
     * Update status for the model (Applicant) and log the change.
     */
    public function updateStatus($newStatus, $remarks = null, $actorId = null, $actorType = null)
    {
        $oldStatus = $this->status;

        // If no change, skip
        if ($oldStatus === $newStatus) {
            return false;
        }

        // // Update model
        // $this->status = $newStatus;
        // $this->save();

        // Detect actor
        $actorType = $actorType ?? (Auth::check() ? 'user' : 'applicant');
        $actorId   = $actorId ?? (Auth::check() ? Auth::id() : $this->id);

        // Log the change
        ApplicantStatusLog::create([
            'applicant_id'    => $this->id,
            'old_status'      => $oldStatus,
            'new_status'      => $newStatus,
            'changed_by_type' => $actorType,
            'changed_by_id'   => $actorId,
            'remarks'         => $remarks,
        ]);

        return true;
    }
}
