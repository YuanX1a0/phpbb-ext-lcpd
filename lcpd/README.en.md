# LSPD Forum Badges (phpBB Extension)

> **Languages:** [中文](README.md) | [English](README.en.md)

phpBB 3.3 extension that displays LSPD-style badges in the post author sidebar: shield (with badge number), ribbons, and namebar (with name).

- **Extension ID:** `siwode/lcpd` (install path must remain `ext/siwode/lcpd`)
- **Current version:** 1.0.10
- **License:** [GPL-2.0-only](license.txt)

## Authors & credits

| Role | Name | Notes |
|------|------|-------|
| Maintainer | [Yuanx1a0](mailto:2867226901@qq.com) | Current repository maintenance and feature development |
| Original author | [siwode](https://my.siwode.net) | Original extension skeleton and base badge system |

See [AUTHORS.en.md](AUTHORS.en.md).

This repository is a fork and extension of **siwode**’s GPL-2.0 project; modifications are also released under **GPL-2.0-only**.

## Requirements

- phpBB **3.3.x**
- PHP **≥ 7.1.3**
- MySQL / MariaDB / PostgreSQL (same as phpBB)

## Installation

1. Copy this repository into your board: `phpBB/ext/siwode/lcpd`
2. Place badge images under the board `images/` tree:
   - `images/shield/`
   - `images/ribbons/`
   - `images/namebar/`
3. In the ACP go to **Customise → Manage extensions** and enable **LSPD Forum Badges**
4. Configure shields, ribbons, namebars and display size under **ACP → Extensions → LSPD Forum Badges**
5. Purge the board cache

## Features

- Display shield, ribbons and namebar in the post author sidebar
- ACP management of badge assets and per-user assignment
- ACP live adjustment of display size and text position
- UCP: badge number, ribbon sort order, per-component display toggles
- Theme support including ravaio

Full release notes: [CHANGELOG.en.md](CHANGELOG.en.md).

## Development

phpBB extension guide: [Extension Development Guide](https://area51.phpbb.com/docs/dev/3.3.x/extensions/index.html)

## License

Licensed under the [GNU General Public License v2.0 only](license.txt).
