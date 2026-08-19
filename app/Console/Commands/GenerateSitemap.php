<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use App\Models\Category;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';
    protected $description = 'Generate sitemap.xml for the website';

    public function handle()
    {
        $baseUrl = 'https://bzakapparel.com';

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        $staticPages = [
            ['url' => '/', 'priority' => '1.0'],
            ['url' => '/shop', 'priority' => '0.9'],
            ['url' => '/about-us', 'priority' => '0.5'],
            ['url' => '/contact-us', 'priority' => '0.5'],
        ];

        foreach ($staticPages as $page) {
            $xml .= "  <url>\n";
            $xml .= "    <loc>{$baseUrl}{$page['url']}</loc>\n";
            $xml .= "    <priority>{$page['priority']}</priority>\n";
            $xml .= "  </url>\n";
        }

        $categories = Category::where('is_active', 1)->get();
        foreach ($categories as $category) {
            $xml .= "  <url>\n";
            $xml .= "    <loc>{$baseUrl}/category/{$category->slug}</loc>\n";
            $xml .= "    <priority>0.8</priority>\n";
            $xml .= "  </url>\n";
        }

        $products = Product::where('is_active', 1)->get();
        foreach ($products as $product) {
            $xml .= "  <url>\n";
            $xml .= "    <loc>{$baseUrl}/product/{$product->slug}</loc>\n";
            $xml .= "    <priority>0.7</priority>\n";
            $xml .= "  </url>\n";
        }

        $xml .= '</urlset>';

        file_put_contents(public_path('sitemap.xml'), $xml);

        $this->info('Sitemap generated successfully!');
    }
}