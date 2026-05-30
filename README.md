# LSPD 论坛徽章（phpBB 扩展）

> **Languages:** [中文](README.md) | [English](README.en.md)

phpBB 3.3 扩展，在帖子作者侧栏显示 LSPD 风格徽章：盾牌（含编号）、略章、名牌（含姓名）。

- **扩展 ID**：`siwode/lcpd`（安装路径须保持 `ext/siwode/lcpd`）
- **当前版本**：1.0.10
- **协议**：[GPL-2.0-only](license.txt)

## 作者与致谢

| 角色 | 姓名 | 说明 |
|------|------|------|
| 维护者 | [Yuanx1a0](mailto:2867226901@qq.com) | 当前仓库维护、功能迭代 |
| 原作者 | [siwode](https://my.siwode.net) | 原始扩展与基础架构 |

详见 [AUTHORS.md](AUTHORS.md)（[English](AUTHORS.en.md)）。

本仓库在原作者 **siwode** 的 GPL-2.0 项目基础上修改与扩展；修改部分同样以 **GPL-2.0-only** 发布。

## 环境要求

- phpBB **3.3.x**
- PHP **≥ 7.1.3**
- MySQL / MariaDB / PostgreSQL（与 phpBB 一致）

## 安装

1. 将本仓库内容放到论坛目录：`phpBB/ext/siwode/lcpd`
2. 将徽章图片放入论坛 `images/` 下对应子目录：
   - `images/shield/`
   - `images/ribbons/`
   - `images/namebar/`
3. 进入 **ACP → 自定义 → 管理扩展**，启用 **LSPD论坛徽章**
4. **ACP → 扩展 → LSPD论坛徽章** 中配置盾牌、略章、名牌及显示尺寸
5. 清除论坛缓存

## 主要功能

- 帖子侧栏显示盾牌、略章、名牌
- ACP 管理徽章资源与用户分配
- ACP 在线调整显示尺寸与文字位置
- UCP：警徽编号、略章排序、分别开关警徽/略章/名牌显示
- 支持 ravaio 等主题的样式适配

完整变更见 [CHANGELOG.md](CHANGELOG.md)（[English](CHANGELOG.en.md)）。

## 开发

phpBB 扩展开发文档：[Extension Development Guide](https://area51.phpbb.com/docs/dev/3.3.x/extensions/index.html)

## License

Licensed under the [GNU General Public License v2.0 only](license.txt).
