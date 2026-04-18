<?php

namespace App\Console\Commands;

use App\Http\Controllers\SitemapController;
use App\Support\Seo\SeoBuilder;
use Illuminate\Console\Command;

class GenerateSitemapCommand extends Command
{
    protected $signature = 'sitemap:generate';

    protected $description = 'Generate the public sitemap.xml file.';

    public function handle(SitemapController $sitemap, SeoBuilder $seo): int
    {
        $path = public_path('sitemap.xml');

        $sitemap->build($seo)->writeToFile($path);

        $this->info('Sitemap generated at '.$path);

        return self::SUCCESS;
    }
}
