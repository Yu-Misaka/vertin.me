<!DOCTYPE HTML>
<html lang="zh-CN">

<head>
    <meta charset="<?= $this->options->charset(); ?>">

    <link rel="preconnect" href="https://cdn.academe.city" crossorigin>
    <link rel="preconnect" href="https://mirrors.sustech.edu.cn" crossorigin>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->header(); ?>
    <?php if ($this->is('post') || $this->is('page')): ?>
        <link rel="canonical" href="<?php $this->permalink(); ?>">
    <?php endif; ?>

    <title>
        <?php $this->archiveTitle([
            'category' => _t('分类 %s 下的文章'),
            'search' => _t('包含关键字 %s 的文章'),
            'tag' => _t('标签 %s 下的文章'),
            'author' => _t('%s 发布的文章')
        ], '', ' - '); ?>
        <?= $this->options->title(); ?>
    </title>

    <?php generateDynamicCSS(); ?>

    <script>
        window.THEME_URL = '<?= $this->options->themeUrl; ?>';
    </script>

    <!-- 主题防闪烁脚本 -->
    <script>
        (function () {
            const cookieMatch = document.cookie.match(/(?:^|;)\s*theme=([^;]+)/), cookieTheme = cookieMatch ? cookieMatch[1] : null;
            const localTheme = localStorage.getItem('theme');
            let initialTheme = cookieTheme || localTheme || 'auto';
            if (initialTheme === 'auto') {
                initialTheme = window.matchMedia('(prefers-color-scheme:dark)').matches ? 'dark' : 'light';
            }
            document.documentElement.setAttribute('data-theme', initialTheme);
            try {
                if (window.matchMedia && !window.matchMedia('(prefers-reduced-motion:reduce)').matches) {
                    <?php if ($this->is('index') || $this->is('archive')): ?>
                        document.documentElement.classList.add('ps-preload-list-enter');
                    <?php elseif ($this->is('post')): ?>
                        document.documentElement.classList.add('ps-preload-post-enter');
                    <?php elseif ($this->is('page')): ?>
                        document.documentElement.classList.add('ps-preload-page-enter');
                    <?php endif; ?>
                }
            } catch (e) { }
        })();
    </script>

    <!-- 性能优化：CSS 预加载 -->
    <link rel="preload" href="<?= $this->options->themeUrl('css/PureSuck_Style.css'); ?>" as="style">
    <link rel="stylesheet" href="<?= $this->options->themeUrl('css/PureSuck_Style.css'); ?>">

    <link rel="preload" href="<?= $this->options->themeUrl('css/fontello.css'); ?>" as="style">
    <link rel="stylesheet" href="<?= $this->options->themeUrl('css/fontello.css'); ?>">

    <!-- ICON Setting -->
    <link rel="icon"
        href="<?= isset($this->options->logoUrl) && $this->options->logoUrl ? $this->options->logoUrl : $this->options->themeUrl . '/images/avatar.ico'; ?>"
        type="image/x-icon">

    <!-- 关键CSS同步加载（避免FOUC） -->
    <link rel="stylesheet" href="<?php $this->options->themeUrl('/css/PureSuck_Module.css'); ?>">
    <link rel="stylesheet" href="<?php $this->options->themeUrl('/css/MoxDesign.css'); ?>">
    <link rel="stylesheet" href="<?php $this->options->themeUrl('/css/animations/index.css'); ?>">
    <link rel="stylesheet" href="<?php $this->options->themeUrl('/css/OwO.min.css'); ?>">

    <!-- 自定义：字体-->
    <link rel="stylesheet" href="<?php $this->options->themeUrl('/css/result.css'); ?>">

    <!-- 自定义：APlayer CSS -->
    <link rel="stylesheet" href="<?php $this->options->themeUrl('/css/APlayer.min.css'); ?>">

    <!-- 自定义：KaTeX CSS -->
    <link rel="stylesheet" href="https://mirrors.sustech.edu.cn/cdnjs/ajax/libs/KaTeX/0.16.9/katex.min.css">

    <!-- 标题线条 -->
    <?php if ($this->options->postTitleAfter != 'off'): ?>
        <style>
            .post-title::after {
                content: "";
                bottom:
                    <?php echo $this->options->postTitleAfter == 'wavyLine' ? '-5px' : '5px'; ?>
                ;
                left:
                    <?php echo '0'; ?>
                ;
                <?php if ($this->options->postTitleAfter == 'boldLine'): ?>
                    width:
                        <?php echo '58px'; ?>
                    ;
                    height:
                        <?php echo '11px'; ?>
                    ;
                <?php elseif ($this->options->postTitleAfter == 'wavyLine'): ?>
                    width:
                        <?php echo '106px'; ?>
                    ;
                    height:
                        <?php echo '12px'; ?>
                    ;
                    mask:
                        <?php echo "url('data:image/svg+xml;utf8,<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"40\" height=\"10\" viewBox=\"0 0 40 10\" preserveAspectRatio=\"none\"><path d=\"M0 5 Q 10 0, 20 5 T 40 5\" stroke=\"black\" stroke-width=\"2\" fill=\"transparent\"/></svg>') repeat-x"; ?>
                    ;
                    mask-size:
                        <?php echo '40px 12px'; ?>
                    ;
                <?php elseif ($this->options->postTitleAfter == 'handDrawn'): ?>
                    /* 添加手绘风格的样式 */
                    /* 这里可以添加具体的手绘风格的样式 */
                <?php endif; ?>
            }
        </style>
    <?php endif; ?>

    <!-- JS引入：按优先级分组加载（性能优化版） -->

    <!-- 高优先级：核心模块（首屏必需） -->
    <script defer src="<?php getStaticURL(path: 'medium-zoom.min.js'); ?>"></script>
    <script defer src="<?php $this->options->themeUrl('/js/PureSuck_Module.js'); ?>"></script>
    <script defer src="<?php $this->options->themeUrl('/js/MoxDesign.js'); ?>"></script>

    <!-- 懒加载管理器（必须在 Swup 之前加载） -->
    <script defer src="<?php $this->options->themeUrl('/js/PureSuck_LazyLoad.js'); ?>"></script>

    <!-- Swup 4：页面过渡动画 -->
    <script defer src="<?php getStaticURL(path: 'Swup.umd.min.js'); ?>"></script>
    <script defer src="<?php $this->options->themeUrl('/js/lib/Swup/scroll-plugin.js'); ?>"></script>
    <script defer src="<?php $this->options->themeUrl('/js/lib/Swup/preload-plugin.js'); ?>"></script>
    <script defer src="<?php $this->options->themeUrl('/js/lib/Swup/head-plugin.js'); ?>"></script>
    <script defer src="<?php $this->options->themeUrl('/js/PureSuck_Swup.js'); ?>"></script>

    <!-- 低优先级：按需加载（评论区） -->
    <script async src="<?php $this->options->themeUrl('/js/OwO.min.js'); ?>"></script>

    <!-- 自定义：KaTeX JS -->
    <script defer src="https://mirrors.sustech.edu.cn/cdnjs/ajax/libs/KaTeX/0.16.9/katex.min.js"></script>
    <script defer src="https://mirrors.sustech.edu.cn/cdnjs/ajax/libs/KaTeX/0.16.9/contrib/auto-render.min.js"></script>

    <!-- 自定义：APlayer JS -->
    <script src="https://mirrors.sustech.edu.cn/cdnjs/ajax/libs/aplayer/1.10.1/APlayer.min.js"></script>
    
    <!-- 自定义：LaTeX 渲染 -->
    <script defer type="text/javascript">
        function renderLatex() {
            if (typeof renderMathInElement !== 'undefined') {
                renderMathInElement(document.body, {
                    delimiters: [{
                        left: "$$",
                        right: "$$",
                        display: true
                    }, {
                        left: "$",
                        right: "$",
                        display: false
                    }],
                    ignoredTags: ["script", "noscript", "style", "textarea", "pre", "code"],
                    ignoredClasses: ["nokatex"]
                });
            }
        }
    
        document.addEventListener("DOMContentLoaded", function() {
            renderLatex();
        });
    </script>

    <?php if ($this->options->PjaxScript): ?>
        <script defer>
            // 注册用户自定义回调（Swup page:view 后执行）
            window.pjaxCustomCallback = function () {
                <?= $this->options->PjaxScript; ?>
                // 自定义：Swup 切换后重新渲染 LaTeX
                renderLatex();
            };
        </script>
    <?php else: ?>
        <script defer>
            // 自定义：Swup 切换后重新渲染 LaTeX
            window.pjaxCustomCallback = function () {
                renderLatex();
            };
        </script>
    <?php endif; ?>
</head>

<body>
    <div class="wrapper">
        <header class="header" data-js="header">
            <div class="wrapper header-wrapper header-title">
                <a href="<?= $this->options->logoIndexUrl ?: $this->options->siteUrl; ?>" class="avatar-link"
                    aria-label="博主名字">
                    <span class="el-avatar el-avatar--circle avatar-hover-effect">
                        <img src="<?= $this->options->logoIndex; ?>" style="object-fit:cover;" alt="博主头像" width="120"
                            height="120" data-name="博主名字" draggable="false" fetchpriority="high" decoding="async"
                            loading="eager">
                    </span>
                </a>
                <div class="header-title">
                    <?= $this->options->titleIndex(); ?>
                </div>
                <p itemprop="description" class="header-item header-about">
                    <?= $this->options->customDescription ?: 'ワクワク'; ?>
                </p>
                <div class="nav header-item left-side-custom-code">
                    <?= $this->options->leftSideCustomCode ?: ''; ?>
                </div>
                <nav class="nav header-item header-nav">
                    <span class="nav-item<?= $this->is('index') ? ' nav-item-current' : ''; ?>">
                        <a href="<?= $this->options->siteUrl(); ?>" title="首页">
                            <span itemprop="name">首页</span>
                        </a>
                    </span>
                    <!--循环显示页面-->
                    <?php $this->widget('Widget_Contents_Page_List')->to($pages); ?>
                    <?php while ($pages->next()): ?>
                        <span class="nav-item<?= $this->is('page', $pages->slug) ? ' nav-item-current' : ''; ?>">
                            <a href="<?= $pages->permalink(); ?>" title="<?= $pages->title(); ?>">
                                <span><?= $pages->title(); ?></span>
                            </a>
                        </span>
                    <?php endwhile; ?>
                    <!--结束显示页面-->
                </nav>
                <div class="theme-toggle-container">
                    <button class="theme-toggle" onclick="toggleTheme()" aria-label="日夜切换">
                        <span id="theme-icon"></span>
                    </button>
                </div>
                <div style="color:#1d1f20" class="nav header-item left-side-custom-code">
                    &emsp;
                </div>
                <div style="text-align:left" id="aplayer">
                    <script type="text/javascript">
                        const ap = new APlayer({
                        //定义容器
                        container: document.getElementById('aplayer'),
                        theme: '#ab8748',
                        listFolded: true,
                        listMaxHeight: 90,
                        //关于音频的相关参数：
                        audio: [
                            {name: 'The Full Mix (Bonus Track)',url: 'https://cdn.academe.city/vertin.me/playlist/10.-The-Full-Mix-Bonus-Track.mp3',cover: 'https://cdn.academe.city/vertin.me/playlist/00.-2-Mello-Superliminal-The-Lo-Fi-Mix.webp'},
                            {name: 'Strange Worlds',url: 'https://cdn.academe.city/vertin.me/playlist/Laryssa-Okada-Manifold-Garden-Original-Soundtrack-26-Strange-Worlds.mp3',cover: 'https://cdn.academe.city/vertin.me/playlist/Laryssa-Okada-Manifold-Garden-Original-Soundtrack-26-Strange-Worlds-mp3-image.webp'},
                            {name: 'Animenz-Only-my-railgun-某科学的超电磁炮-OP1',url: 'https://cdn.academe.city/vertin.me/playlist/Animenz-Only-my-railgun-某科学的超电磁炮-OP1.mp3', cover: 'https://cdn.academe.city/vertin.me/playlist/Animenz-Only-my-railgun-某科学的超电磁炮-OP1-mp3-image.webp'},
                            {name: '08M34-End-Credit-Day-One', url: 'https://cdn.academe.city/vertin.me/playlist/Hans-Zimmer-08M34-End-Credit-Day-One-v10.03-／-End-Credit-2-Day-One-v7.09-／-End-Credit-3-08M32.mp3', cover: 'https://cdn.academe.city/vertin.me/playlist/Hans-Zimmer-08M34-End-Credit-Day-One-v10-03-／-End-Credit-2-Day-One-v7-09-／-End-Credit-3-08M32-mp3-image.webp'},
                        ]});
                    </script>
                </div>
                <style>
                    .aplayer .aplayer-list {
                        max-height: 96px !important;
                        overflow-y: auto !important;
                    }
                </style>
            </div>
        </header>
        <?php
        $psPageType = 'list';
        if ($this->is('post')) {
            $psPageType = 'post';
        } elseif ($this->is('page')) {
            $psPageType = 'page';
        } elseif ($this->is('index') || $this->is('archive')) {
            $psPageType = 'list';
        }
        ?>
        <div id="swup" data-ps-page-type="<?= $psPageType; ?>">
            <main class="main">