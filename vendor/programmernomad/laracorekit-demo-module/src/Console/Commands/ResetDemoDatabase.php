<?php

namespace LaraCoreKit\DemoModule\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class ResetDemoDatabase extends Command
{
    protected $signature = 'demo:reset {--force : Force reset without confirmation}';

    protected $description = 'Reset demo database and clean uploaded files';

    public function handle(): int
    {
        if (! config('demo.enabled')) {
            $this->error('Demo mode is not enabled');

            return self::FAILURE;
        }

        if (! $this->option('force') && ! $this->confirm('Reset demo database? All data will be lost.')) {
            return self::FAILURE;
        }

        $startTime = now();
        $this->info('Starting demo reset...');

        try {
            $this->info('Running fresh migrations...');
            Artisan::call('migrate:fresh', ['--force' => true]);
            $this->line(Artisan::output());

            $this->info('Seeding database...');
            Artisan::call('db:seed', ['--force' => true]);
            $this->line(Artisan::output());

            if (config('demo.reset.clear_media')) {
                $this->info('Clearing media files...');
                $mediaPath = storage_path('app/public/media');
                if (File::exists($mediaPath)) {
                    File::cleanDirectory($mediaPath);
                    $this->comment('Media files cleared');
                }
            }

            if (config('demo.reset.clear_cache')) {
                $this->info('Clearing cache...');
                Artisan::call('cache:clear');
                Artisan::call('config:clear');
                Artisan::call('route:clear');
                Artisan::call('view:clear');
                $this->comment('Cache cleared');
            }

            if (config('demo.reset.clear_sessions')) {
                $this->info('Clearing sessions...');
                $sessionsPath = storage_path('framework/sessions');
                if (File::exists($sessionsPath)) {
                    File::cleanDirectory($sessionsPath);
                    $this->comment('Sessions cleared');
                }
            }

            $this->info('Rotating logs...');
            $this->rotateLogs();

            $duration = now()->diffInSeconds($startTime);

            Log::info('Demo database reset completed', [
                'duration' => $duration.'s',
                'timestamp' => now()->toDateTimeString(),
            ]);

            $this->newLine();
            $this->info("Demo reset completed successfully in {$duration}s");

            return self::SUCCESS;
        } catch (\Exception $e) {
            Log::error('Demo reset failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            $this->error('Reset failed: '.$e->getMessage());

            return self::FAILURE;
        }
    }

    protected function rotateLogs(): void
    {
        $logPath = storage_path('logs');
        $keepDays = config('demo.reset.preserve_logs_days', 7);
        $cutoffDate = now()->subDays($keepDays);

        $files = File::files($logPath);

        foreach ($files as $file) {
            if ($file->getMTime() < $cutoffDate->timestamp) {
                File::delete($file);
            }
        }

        $this->comment("Logs older than {$keepDays} days removed");
    }
}
