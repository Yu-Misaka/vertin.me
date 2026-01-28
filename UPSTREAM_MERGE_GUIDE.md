# 上游合并指南 (Upstream Merge Guide)

本文档说明如何将上游 [MoXiaoXi233/PureSuck-theme](https://github.com/MoXiaoXi233/PureSuck-theme) 的 `main` 分支合并到本 fork，同时保持自定义功能的兼容性。

> **注意**：上游仓库使用的是 `main` 分支，而不是 `master` 分支。

## 📋 本 Fork 的自定义功能清单

根据代码分析，本 fork 相较于上游有以下自定义内容：

### 1. CDN 和资源预连接
```html
<!-- header.php 中的自定义 CDN -->
<link rel="preconnect" href="https://cdn.academe.city" crossorigin>
<link rel="preconnect" href="https://mirrors.sustech.edu.cn" crossorigin>
```

### 2. APlayer 音乐播放器集成
- 在 `header.php` 中嵌入了 APlayer 音乐播放器
- 自定义播放列表配置
- APlayer CSS 引用 (`css/APlayer.min.css`)

### 3. KaTeX 数学公式支持
- LaTeX 渲染功能 (`renderLatex()`)
- 使用 SUSTech 镜像加载 KaTeX

### 4. 跨域 Cookie 主题同步
- `getRootDomain()` 函数
- `setThemeCookie()` 函数
- 支持子域名间主题同步

### 5. 额外的 CSS 文件
- `css/result.css` - 自定义结果样式
- `css/code-reading.css` - 代码阅读样式

### 6. 额外的 JS 库
- `lean.min.js` - LeanCloud 集成
- Mathematica 语法高亮支持

### 7. 本地字体文件
- `fonts/` 目录下的霞骛文楷和中宋字体（上游已移除）

---

## 🔄 合并步骤

### 步骤 1: 添加上游远程仓库

```bash
# 添加上游远程仓库
git remote add upstream https://github.com/MoXiaoXi233/PureSuck-theme.git

# 验证远程仓库
git remote -v
```

### 步骤 2: 获取上游更新

```bash
# 获取上游所有分支
git fetch upstream

# 查看上游分支
git branch -r | grep upstream
```

### 步骤 3: 创建合并分支

```bash
# 确保在主分支上
git checkout main  # 或 master

# 创建新的合并分支
git checkout -b merge-upstream-$(date +%Y%m%d)
```

### 步骤 4: 执行合并

```bash
# 合并上游 main 分支
git merge upstream/main --no-commit

# 如果出现冲突，查看冲突文件
git status
```

### 步骤 5: 解决冲突

合并时可能会出现冲突的文件：

| 文件 | 冲突原因 | 解决策略 |
|------|----------|----------|
| `header.php` | CDN、APlayer、KaTeX 自定义 | 保留自定义内容，合并上游新功能 |
| `footer.php` | 代码高亮自定义 | 保留自定义配置 |
| `functions.php` | 版本号、自定义函数 | 合并上游新功能，保留自定义函数 |
| `css/PureSuck_Style.css` | 样式差异 | 优先采用上游，测试后调整 |
| `js/PureSuck_Module.js` | 功能差异 | 仔细比较，保留自定义功能 |

#### 解决冲突的一般流程：

```bash
# 对于每个冲突文件
# 1. 打开文件，查找 <<<<<<< 标记
# 2. 决定保留哪些内容
# 3. 删除冲突标记
# 4. 暂存解决后的文件
git add <resolved-file>

# 完成合并
git commit -m "Merge upstream/main with custom features preserved"
```

---

## 🔧 具体文件合并策略

### header.php 合并策略

1. **保留的自定义内容**：
   - CDN preconnect 链接
   - APlayer 相关代码
   - KaTeX 相关代码
   - Cookie 主题同步代码
   - 自定义 CSS 引用

2. **采用上游的更新**：
   - 新的动画系统 (`css/animations/`)
   - 优化的防闪烁脚本
   - Swup 页面过渡（如需要）

3. **合并模板**：
```php
<!-- 在 <head> 开始处添加自定义 preconnect -->
<link rel="preconnect" href="https://cdn.academe.city" crossorigin>
<link rel="preconnect" href="https://mirrors.sustech.edu.cn" crossorigin>

<!-- 保留上游的核心 CSS -->
<!-- 在适当位置添加自定义 CSS -->
<link href="<?php $this->options->themeUrl('/css/result.css'); ?>" rel="stylesheet">
<link href="<?php $this->options->themeUrl('/css/code-reading.css'); ?>" rel="stylesheet">

<!-- 在 JS 部分添加自定义脚本 -->
<script src="https://mirrors.sustech.edu.cn/cdnjs/ajax/libs/KaTeX/0.16.9/katex.min.js"></script>
<!-- ... 其他自定义脚本 ... -->
```

### functions.php 合并策略

1. **保留上游的核心功能更新**
2. **保留自定义的 `getStaticURL()` 函数**（如果有）
3. **更新版本号为上游版本**
4. **保留自定义配置项**

### footer.php 合并策略

基本可以保留自定义版本，但检查上游是否有重要更新。

---

## 📦 处理被删除的文件

上游可能删除了以下文件，但你的 fork 需要保留：

### 需要保留的文件
```
css/APlayer.min.css        # APlayer 样式
css/code-reading.css       # 代码阅读样式  
css/result.css             # 结果样式
js/lib/aos.js              # AOS 动画库（如果自定义使用）
js/lib/highlight.min.js    # 代码高亮（如果自定义配置）
js/lib/pjax.min.js         # Pjax（如果启用）
js/lib/pace.min.js         # 加载进度条
css/lib/aos.css            # AOS 样式
fonts/*                    # 本地字体（可选）
```

在合并后，确保这些文件存在：
```bash
# 检查文件是否被删除
git status

# 如果文件被删除，恢复它们
git checkout HEAD -- css/APlayer.min.css
git checkout HEAD -- css/code-reading.css
# ... 等等
```

---

## ⚠️ 合并后的测试清单

合并完成后，请测试以下功能：

- [ ] 首页正常加载
- [ ] 文章页面正常显示
- [ ] 代码高亮正常工作
- [ ] APlayer 音乐播放正常
- [ ] LaTeX 公式正常渲染
- [ ] 深色/浅色主题切换正常
- [ ] 主题状态跨子域同步正常
- [ ] TOC 目录树正常
- [ ] 评论区 OwO 表情正常
- [ ] Pjax 页面加载正常（如启用）
- [ ] 移动端响应式正常

---

## 🚀 自动化合并脚本（可选）

创建一个脚本来简化合并流程：

```bash
#!/bin/bash
# merge-upstream.sh

set -e

echo "=== 开始合并上游更新 ==="

# 获取上游更新
git fetch upstream

# 创建合并分支
BRANCH_NAME="merge-upstream-$(date +%Y%m%d)"
git checkout -b $BRANCH_NAME

# 尝试合并
if git merge upstream/main --no-commit; then
    echo "✅ 自动合并成功！请检查更改后提交。"
else
    echo "⚠️ 存在冲突，请手动解决后提交。"
    echo "冲突文件："
    git diff --name-only --diff-filter=U
fi

# 恢复必要的自定义文件（如果被删除）
CUSTOM_FILES=(
    "css/APlayer.min.css"
    "css/code-reading.css"
    "css/result.css"
)

for file in "${CUSTOM_FILES[@]}"; do
    if [ ! -f "$file" ]; then
        echo "恢复自定义文件: $file"
        git checkout HEAD -- "$file" 2>/dev/null || echo "文件不存在: $file"
    fi
done

echo "=== 合并准备完成 ==="
```

---

## 📝 版本兼容性说明

| 上游版本 | 兼容性 | 注意事项 |
|---------|--------|----------|
| 1.3.0 | ✅ 兼容 | 需要手动合并自定义功能 |
| 1.3.1 | ✅ 兼容 | 字数统计更新 |
| Swup 分支 | ⚠️ 需测试 | 新的页面过渡系统，可能与 Pjax 冲突 |

---

## 🔗 相关资源

- [上游仓库](https://github.com/MoXiaoXi233/PureSuck-theme)
- [PureSuck 主题文档](https://github.com/MoXiaoXi233/PureSuck-theme/blob/main/README.md)
- [Git 合并冲突解决指南](https://git-scm.com/book/zh/v2/Git-分支-分支的新建与合并)

---

*最后更新: 2025-01-28*
