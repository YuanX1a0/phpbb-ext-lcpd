# Changelog

> **Languages:** [中文](CHANGELOG.md) | [English](CHANGELOG.en.md)

All notable changes to [Yuanx1a0/phpbb-ext-lcpd](https://github.com/Yuanx1a0/phpbb-ext-lcpd) are documented here.  
Format based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/); versioning follows [Semantic Versioning](https://semver.org/).

## [1.0.10] - 2026-05-30

### Added

- **UCP → Profile → Edit profile**: users can toggle display of **shield**, **ribbons** and **namebar** separately in posts.

## [1.0.9] - 2026-05-30

### Added

- **UCP → Profile → Edit profile**: users can reorder assigned ribbons (move up / down).

### Changed

- Namebar name text is shown in **uppercase**.

## [1.0.8] - 2026-05-30

### Added

- **UCP → Profile → Edit profile**: users can set their badge number.
- **ACP → Display size → Text position**: adjust badge number on shield and name on namebar (percent) plus number font size.

### Changed

- Badge area is **center-aligned** (no longer left-aligned).
- Name/number fonts follow **nametag** style: Arial bold; number color `#22255B` with shadow.
- Badge number on **shield image**; name centered on namebar image.

## [1.0.7] - 2026-05-30

### Fixed

- Namebar name text is **overlaid at the center** of the image instead of below it.

## [1.0.6] - 2026-05-30

### Changed

- Default display sizes restored to original v1.0.1 values: shield 48px, ribbons 28×20px, namebar 120×22px, wrap width 160px.
- Migration updates previously saved smaller sizes in the database to the new defaults on upgrade.

## [1.0.5] - 2026-05-30

### Fixed

- ACP “Display size” reset button was HTML `type="reset"` (form-only, not saved). Replaced with **“Restore defaults”** that writes built-in defaults to the database.

## [1.0.4] - 2026-05-30

### Fixed

- Theme CSS (e.g. ravaio) overrode extension styles so ACP display size had no effect; fixed with **inline styles + `!important`**.
- Fixed ribbon block variable in `styles/all` template (`lcpd_post_ribbons` → `postrow.lcpd_post_ribbons`) so ribbons showed on themes using the all template.

### Added

- **`styles/ravaio/`** theme-specific template and CSS; auto-loaded when ravaio style is active.

## [1.0.3] - 2026-05-30

### Added

- **ACP → LSPD Forum Badges → Display size**: change badge sizes from the ACP; takes effect after save.
- `service/display_settings.php` centralises size config (stored in phpBB `config` table).

### Removed

- `config/lcpd_display.yml` file-based configuration.

### Changed

- Migration registers the display size ACP module and default config on extension update.

## [1.0.2] - 2026-05-30

### Added

- **`config/lcpd_display.yml`**: customise front-end badge sizes (px) with inline comments.
- Sizes injected via CSS variables; purge cache after editing.

### Changed

- Smaller default sizes (shield 32px, ribbons 14px height, etc.).
- Version bumped to 1.0.2.

## [1.0.1] - 2026-05-30

### Fixed

- Badges in the post author area displayed at full image size and appeared too large.
- Added `styles/all/theme/lcpd.css` with max width/height so badges fit the sidebar.

### Changed

- Added `.lcpd-badge-wrap` container in `viewtopic_body_post_author_after.html` for all three theme packs.
- `event/main_listener.php` loads extension stylesheet on `core.page_header`.

## [1.0.0] - 2025-12-03

### Added

- Original release by siwode.
