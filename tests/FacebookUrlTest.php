<?php

namespace Maina888\FacebookFeed\Tests;

use Maina888\FacebookFeed\Support\FacebookUrl;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class FacebookUrlTest extends TestCase
{
    public static function videoLinks(): array
    {
        return [
            ['https://www.facebook.com/yourshop/videos/1234567890123456/', true],
            ['https://www.facebook.com/yourshop/videos/new-arrivals/1234567890123456', true],
            ['https://www.facebook.com/watch/?v=1234567890123456', true],
            ['https://www.facebook.com/reel/1234567890123456', true],
            ['https://m.facebook.com/reel/1234567890123456?mibextid=abc', true],
            ['https://www.facebook.com/share/v/AbC123xyz/', true],
            ['https://www.facebook.com/share/r/AbC123xyz/', true],
            ['https://www.facebook.com/video.php?v=1234567890123456', true],
            ['https://fb.watch/abcDEF123/', true],
            ['https://www.facebook.com/yourshop', false],
            ['https://www.facebook.com/yourshop/photos/123', false],
            ['https://evil.example/facebook.com/reel/1234567890123456', false],
            ['https://facebook.com.evil.example/reel/1234567890123456', false],
            ['', false],
            [null, false],
        ];
    }

    #[DataProvider('videoLinks')]
    public function test_it_recognises_video_links(?string $url, bool $valid): void
    {
        $this->assertSame($valid, FacebookUrl::isVideoUrl($url));
    }

    public function test_it_builds_the_embed_url(): void
    {
        $this->assertSame(
            'https://www.facebook.com/plugins/video.php?href=https%3A%2F%2Fwww.facebook.com%2Freel%2F123&show_text=false&autoplay=false',
            FacebookUrl::embedUrl('https://www.facebook.com/reel/123')
        );
    }

    public static function pages(): array
    {
        return [
            ['https://www.facebook.com/yourshop', 'https://www.facebook.com/yourshop'],
            ['yourshop', 'https://www.facebook.com/yourshop'],
            ['@your.shop', 'https://www.facebook.com/your.shop'],
            ['https://example.com/yourshop', null],
            ['javascript:alert(1)', null],
            ['', null],
            [null, null],
        ];
    }

    #[DataProvider('pages')]
    public function test_it_builds_the_page_url(?string $value, ?string $url): void
    {
        $this->assertSame($url, FacebookUrl::pageUrl($value));
    }
}
