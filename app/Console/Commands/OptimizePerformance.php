<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use App\Services\CacheService;

class OptimizePerformance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'optimize:performance 
                            {--cache : Clear and rebuild application caches}
                            {--config : Cache configuration files}
                            {--routes : Cache routes}
                            {--views : Cache views}
                            {--all : Run all optimizations}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Optimize application performance by caching configurations, routes, and clearing old caches';

    /**
     * The cache service instance.
     *
     * @var CacheService
     */
    protected $cacheService;

    /**
     * Create a new command instance.
     */
    public function __construct(CacheService $cacheService)
    {
        parent::__construct();
        $this->cacheService = $cacheService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🚀 Starting performance optimization...');

        if ($this->option('all') || $this->option('cache')) {
            $this->optimizeCaches();
        }

        if ($this->option('all') || $this->option('config')) {
            $this->optimizeConfig();
        }

        if ($this->option('all') || $this->option('routes')) {
            $this->optimizeRoutes();
        }

        if ($this->option('all') || $this->option('views')) {
            $this->optimizeViews();
        }

        if ($this->option('all')) {
            $this->optimizeAutoloader();
        }

        $this->info('✅ Performance optimization completed!');
        
        return Command::SUCCESS;
    }

    /**
     * Optimize application caches
     */
    private function optimizeCaches()
    {
        $this->info('🧹 Clearing application caches...');
        
        // Clear all caches
        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        Artisan::call('route:clear');
        Artisan::call('config:clear');

        $this->line('Application caches cleared.');

        // Warm up common caches
        $this->info('🔥 Warming up application caches...');
        $this->cacheService->getAvailableRooms(6);
        $this->cacheService->getActiveFerrySchedulesCount();
        $this->cacheService->getActiveLocationsCount();
        $this->cacheService->getDashboardImages();
        
        $this->line('Application caches warmed up.');
    }

    /**
     * Optimize configuration caching
     */
    private function optimizeConfig()
    {
        $this->info('⚙️ Caching configuration files...');
        Artisan::call('config:cache');
        $this->line('Configuration cached.');
    }

    /**
     * Optimize route caching
     */
    private function optimizeRoutes()
    {
        $this->info('🛣️ Caching routes...');
        Artisan::call('route:cache');
        $this->line('Routes cached.');
    }

    /**
     * Optimize view caching
     */
    private function optimizeViews()
    {
        $this->info('👀 Caching views...');
        Artisan::call('view:cache');
        $this->line('Views cached.');
    }

    /**
     * Optimize autoloader
     */
    private function optimizeAutoloader()
    {
        $this->info('🔄 Optimizing autoloader...');
        
        // Run composer dump-autoload -o for optimization
        exec('composer dump-autoload -o 2>&1', $output, $returnCode);
        
        if ($returnCode === 0) {
            $this->line('Autoloader optimized.');
        } else {
            $this->warn('Could not optimize autoloader. Make sure composer is available.');
        }
    }
}
