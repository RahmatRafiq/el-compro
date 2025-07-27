<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PopulateVirtualSlugs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:populate-virtual-slugs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Populate slugs for existing virtual tour records';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting to populate slugs for virtual tours...');
        
        $virtuals = \App\Models\Virtual::whereNull('slug')->orWhere('slug', '')->get();
        $count = 0;
        
        foreach ($virtuals as $virtual) {
            $virtual->slug = \Illuminate\Support\Str::slug($virtual->name);
            $virtual->save();
            $count++;
        }
        
        $this->info("Completed! {$count} virtual tour records updated with slugs.");
    }
}
