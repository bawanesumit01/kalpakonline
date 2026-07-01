<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Category;
use Illuminate\Support\Str;

class GenerateCategorySlugs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-category-slugs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate slugs for all categories without slugs';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $categories = Category::whereNull('slug')->orWhere('slug', '')->get();

        if ($categories->isEmpty()) {
            $this->info('All categories already have slugs!');
            return;
        }

        $count = 0;
        foreach ($categories as $category) {
            $category->slug = Str::slug($category->category_name);
            $category->save();
            $count++;
            $this->line("Generated slug for: {$category->category_name} → {$category->slug}");
        }

        $this->info("✅ Successfully generated slugs for {$count} categories!");
    }
}
