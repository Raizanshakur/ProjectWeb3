<?php

namespace App\Jobs;

use App\Models\FoodAnalysis;
use App\Services\FoodAnalysisService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessFoodAnalysisJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 2;
    public int $timeout = 60;
    public bool $deleteWhenMissingModels = true;

    public function __construct(public FoodAnalysis $foodAnalysis)
    {
        $this->afterCommit = true;
    }

    /**
     * Execute the job.
     */
    public function handle(FoodAnalysisService $service): void
    {
        $service->processAnalysis($this->foodAnalysis);
    }

    /**
     * Handle a job failure.
     */
    public function failed(?\Throwable $exception): void
    {
        if ($this->foodAnalysis->exists) {
            $this->foodAnalysis->update([
                'status' => 'failed',
                'error_message' => 'Proses analisis gagal diselesaikan oleh antrean worker.',
                'analyzed_at' => now(),
            ]);
        }
    }
}
