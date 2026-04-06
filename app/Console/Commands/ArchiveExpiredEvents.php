<?php

namespace App\Console\Commands;

use App\Models\Event;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ArchiveExpiredEvents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'events:archive-expired 
                            {--days=1 : Number of days after end date to archive}
                            {--dry-run : Run without actually archiving}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically archive events that have ended X days ago';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $daysAfterEnd = $this->option('days');
        $dryRun = $this->option('dry-run');
        
        $cutoffDate = now()->subDays($daysAfterEnd);
        
        $this->info("Looking for events that ended before: " . $cutoffDate->format('Y-m-d H:i:s'));
        
        // Find events that have ended and are not archived
        $expiredEvents = Event::where('is_archived', false)
            ->where('status', 'published')
            ->where(function ($query) use ($cutoffDate) {
                $query->where('end_date', '<', $cutoffDate->toDateString())
                    ->orWhere(function ($q) use ($cutoffDate) {
                        $q->where('end_date', $cutoffDate->toDateString())
                            ->where('end_time', '<', $cutoffDate->format('H:i:s'));
                    });
            })
            ->get();
        
        $count = $expiredEvents->count();
        
        if ($count === 0) {
            $this->info('No expired events found to archive.');
            return Command::SUCCESS;
        }
        
        $this->info("Found {$count} event(s) to archive.");
        
        if ($dryRun) {
            $this->warn("DRY RUN - No events were actually archived.");
            $this->table(
                ['ID', 'Title', 'End Date', 'End Time'],
                $expiredEvents->map(fn($e) => [
                    $e->id,
                    $e->title,
                    $e->end_date->format('Y-m-d'),
                    $e->end_time
                ])
            );
            return Command::SUCCESS;
        }
        
        $archived = 0;
        $failed = 0;
        
        foreach ($expiredEvents as $event) {
            try {
                $event->archive(null); // null because it's system automatic
                $archived++;
                $this->line("✓ Archived: {$event->title}");
            } catch (\Exception $e) {
                $failed++;
                $this->error("✗ Failed to archive {$event->title}: " . $e->getMessage());
                Log::error("Auto-archive failed for event {$event->id}: " . $e->getMessage());
            }
        }
        
        $this->newLine();
        $this->info("Archiving complete: {$archived} archived, {$failed} failed.");
        
        // Log summary
        Log::info("Auto-archive completed", [
            'events_found' => $count,
            'events_archived' => $archived,
            'events_failed' => $failed
        ]);
        
        return Command::SUCCESS;
    }
}