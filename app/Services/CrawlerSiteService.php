<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Symfony\Component\DomCrawler\Crawler;

class CrawlerSiteService
{    
    public function crawler(string $url)
    {
        $response = Http::get($url);
        if (!$response->successful()) {
            return $response->status();
        }

        $crawler = new Crawler($response->body());
        return [
            'title' => $this->getTitle($crawler),
            'description' => $this->getDescription($crawler),
            'image' => $this->getImage($crawler),
            'url' => $url
        ];
    }

    protected function getTitle(Crawler $crawler): ?string
    {
        $titlePath = $crawler->filterXPath('//head/title');
        if ($titlePath->count()) {
            return $titlePath->text();
        }

        $titlePath = $crawler->filterXPath('//head/meta[@property="og:title"]');
        if ($titlePath->count()) {
            return $titlePath->attr('content');
        }

        return null;
    }

    protected function getDescription(Crawler $crawler): ?string
    {
        $descriptionPath = $crawler->filterXPath('//head/meta[@name="description"]');
        if ($descriptionPath->count()) {
            return $descriptionPath->attr('content');
        }

        $descriptionPath = $crawler->filterXPath('//head/meta[@property="og:description"]');
        if ($descriptionPath->count()) {
            return $descriptionPath->attr('content');
        }

        return null;
    }

    protected function getImage(Crawler $crawler): ?string
    {
        $imagePath = $crawler->filterXPath('//head/meta[@property="og:image"]');
        if ($imagePath->count()) {
            return $imagePath->attr('content');
        }

        $imagePath = $crawler->filterXPath('//head/meta[@property="twitter:image"]');
        if ($imagePath->count()) {
            return $imagePath->attr('content');
        }

        return null;
    }

}
