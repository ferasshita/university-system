<?php

namespace App\Jobs;

use App\Models\AuditLog;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class AuditLogJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function handle()
    {
        try {
            AuditLog::create([
                'user_id' => $this->data['user_id'] ?? null,
                'action' => $this->data['action'],
                'resource_type' => $this->data['resource_type'] ?? null,
                'resource_id' => $this->data['resource_id'] ?? null,
                'old_data' => $this->data['old_data'] ?? null,
                'new_data' => $this->data['new_data'] ?? null,
                'ip' => $this->data['ip'] ?? request()->ip(),
                'user_agent' => $this->data['user_agent'] ?? request()->userAgent(),
            ]);
        } catch (\Exception $e) {
            Log::error('Audit log failed: ' . $e->getMessage());
        }
    }
}
