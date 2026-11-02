<?php

namespace Maina888\FacebookFeed\Support;

/**
 * Checks Facebook links without any framework dependency, so it can be unit tested on its own.
 */
class FacebookUrl
{
    protected const HOST = '#^https?://(?:[a-z0-9-]+\.)*(?:facebook\.com|fb\.com|fb\.watch)(?:/|$)#i';

    /**
     * True for a public Facebook video or reel link: /<page>/videos/<id>, /watch/?v=<id>, /reel/<id>,
     * /share/v/<code>, /share/r/<code>, video.php?v=<id> or fb.watch/<code>.
     */
    public static function isVideoUrl(?string $url): bool
    {
        $url = trim((string) $url);

        if ($url === '' || ! preg_match(self::HOST, $url)) {
            return false;
        }

        return (bool) preg_match(
            '#^https?://(?:[a-z0-9-]+\.)*(?:'
            . 'fb\.watch/[A-Za-z0-9_-]+'
            . '|(?:facebook|fb)\.com/(?:'
            . '[A-Za-z0-9.\-]+/videos/(?:[^/?\#]+/)?\d+'
            . '|watch/?\?(?:.*&)?v=\d+'
            . '|reel/\d+'
            . '|share/[vr]/[A-Za-z0-9_-]+'
            . '|video\.php\?(?:.*&)?v=\d+'
            . '))#i',
            $url
        );
    }

    public static function embedUrl(string $videoUrl): string
    {
        return 'https://www.facebook.com/plugins/video.php?href=' . urlencode(trim($videoUrl))
            . '&show_text=false&autoplay=false';
    }

    /**
     * Page link for the follow button. Accepts a full facebook.com URL or a page username; anything else gives null.
     */
    public static function pageUrl(?string $value): ?string
    {
        $value = trim((string) $value);

        if ($value === '') {
            return null;
        }

        if (preg_match('#^https?://#i', $value)) {
            return preg_match(self::HOST, $value) && ! preg_match('/[\s"\'<>]/', $value) ? $value : null;
        }

        $value = ltrim($value, '@');

        return preg_match('/^[A-Za-z0-9.\-]{2,80}$/', $value) ? 'https://www.facebook.com/' . $value : null;
    }
}
