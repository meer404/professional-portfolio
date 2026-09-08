<?php

namespace App\Console\Commands;

use App\Models\Project;
use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';

    protected $description = 'Generate the public sitemap';

    public function handle(): int
    {
        $sitemap = Sitemap::create()
            ->add(
                Url::create(route('home'))
                    ->setPriority(1.0)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
            )
            ->add(
                Url::create(route('projects.index'))
                    ->setPriority(0.9)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
            );

        // Locale switching on this site is session-based (see App\Http\Middleware\SetLocale),
        // so there is no distinct URL per locale — each page is listed once.
        foreach (Project::ordered()->get() as $project) {
            $sitemap->add(
                Url::create(route('projects.show', $project))
                    ->setPriority(0.8)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                    ->setLastModificationDate($project->updated_at)
            );
        }

        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('Sitemap written to public/sitemap.xml');

        return self::SUCCESS;
    }
}
