# Changelog

## 1.1.0
- First public release on the Botble Marketplace, free under the MIT License, by Maina 888 (Maina Superintelligence Ltd).
- Vendor namespace is now `MainaSuperintelligence\FacebookFeed` and the plugin id is `maina888/facebook-feed`.
- New: privacy mode. A cover image with a play button stands in for each video, and nothing loads from Facebook until the visitor taps play.
- New: cover image per video, shown in privacy mode and in the admin list.
- New: "Distance from the bottom on phones" setting, to clear bottom navigation bars such as Shofy's.
- Faster pages: video embeds now load only when the panel is opened or a slide is shown, never on page load.
- Video links are checked when saving (`/videos/`, `/watch/?v=`, `/reel/`, `/share/v/`, `/share/r/`, `video.php` and `fb.watch` links), and the Facebook Page setting accepts a full Page URL or just its username. Unsafe values are rejected.
- The default shop link must be an `https://` address or a site path.
- The admin list shows the video URL, cover and display order; the display order is no longer reset to 0 when editing.
- Shop page options (shop listing, product, cart, checkout) only appear when the Ecommerce plugin is active, so the plugin works on sites without a shop.
- Escape closes the panel.
- Unit tests for link parsing.

## 1.0.0
- Initial release: floating Facebook video and reel widget with carousel, follow and shop buttons, four positions, three sizes, page targeting, drag to move, auto-open and mobile toggle.
