# 更新日志

> **Languages:** [中文](CHANGELOG.md) | [English](CHANGELOG.en.md)

本文件记录 [Yuanx1a0/phpbb-ext-lcpd](https://github.com/Yuanx1a0/phpbb-ext-lcpd) 扩展的变更，格式参考 [Keep a Changelog](https://keepachangelog.com/zh-CN/1.1.0/)，版本号遵循 [语义化版本](https://semver.org/lang/zh-CN/)。

## [1.0.10] - 2026-05-30

### Added

- **UCP → 个人资料 → 编辑个人信息**：玩家可分别开关是否在帖子中显示 **警徽（盾牌）**、**略章**、**名牌**。

## [1.0.9] - 2026-05-30

### Added

- **UCP → 个人资料 → 编辑个人信息**：玩家可调整已分配略章的显示顺序（上移/下移）。

### Changed

- 名牌上的姓名文字改为 **大写** 显示。

## [1.0.8] - 2026-05-30

### Added

- **UCP → 个人资料 → 编辑个人信息**：玩家可自行填写警徽编号。
- **ACP → 显示尺寸 → 文字位置**：可调整编号在盾牌上、姓名在名牌上的位置（百分比）及编号字号。

### Changed

- 徽章区域改为 **居中对齐**（不再靠左）。
- 姓名/编号字体参考 **nametag**：Arial 粗体，编号颜色 `#22255B` 带阴影。
- 警徽编号显示在 **盾牌图片** 上（与 nametag 一致），姓名显示在名牌图片中央。

## [1.0.7] - 2026-05-30

### Fixed

- 名牌（Namebar）上的姓名文字改为 **叠加在图片正中央**，不再显示在图片下方。

## [1.0.6] - 2026-05-30

### Changed

- 默认显示尺寸恢复为扩展最初版本（v1.0.1）的较大数值：盾牌 48px、略章 28×20px、框标 120×22px、区域宽 160px。
- 升级时自动迁移，将数据库中已保存的小尺寸一并更新为新默认值。

## [1.0.5] - 2026-05-30

### Fixed

- ACP「显示尺寸」页的「重置」按钮原为 HTML `type="reset"`，仅还原表单初始值且不写入数据库；改为 **「恢复默认值」** 按钮，一键恢复内置默认尺寸并保存。

## [1.0.4] - 2026-05-30

### Fixed

- ravaio 等主题 CSS 覆盖扩展样式，导致 ACP「显示尺寸」设置无效；改为 **inline style + !important** 双重约束。
- 修复 `styles/all` 模板中略章区块变量名错误（`lcpd_post_ribbons` → `postrow.lcpd_post_ribbons`），ravaio 等使用 all 模板的风格无法显示略章。

### Added

- 新增 **`styles/ravaio/`** 主题专用模板与 CSS，自动检测 ravaio 风格并加载。

## [1.0.3] - 2026-05-30

### Added

- **ACP → LSPD论坛徽章 → 显示尺寸**：在后台在线修改徽章前台显示大小，保存后立即生效。
- 新增 `service/display_settings.php` 统一管理尺寸配置（存入 phpBB `config` 表）。

### Removed

- 移除 `config/lcpd_display.yml` 文件配置方式。

### Changed

- 升级扩展后会自动运行迁移，注册「显示尺寸」后台菜单及默认配置项。

## [1.0.2] - 2026-05-30

### Added

- 新增 **`config/lcpd_display.yml`**：可自定义前台徽章显示尺寸（单位 px），文件内附中文说明。
- 通过 CSS 变量动态注入尺寸，修改配置后清除缓存即可预览。

### Changed

- 默认尺寸进一步缩小（盾牌 32px、略章 14px 高等）。
- 版本号更新为 1.0.2。

## [1.0.1] - 2026-05-30

### Fixed

- 前台帖子作者区徽章（Shield / Ribbons / Namebar）默认以原图尺寸显示，导致显示过大。
- 新增统一样式表 `styles/all/theme/lcpd.css`，限制各元素最大宽高，使徽章在帖子侧栏内紧凑显示。

### Changed

- 三个主题的 `viewtopic_body_post_author_after.html` 模板增加 `.lcpd-badge-wrap` 容器，便于样式隔离。
- `event/main_listener.php` 在 `core.page_header` 事件中加载扩展样式表。

## [1.0.0] - 2025-12-03

### Added

siwode创作的原版
