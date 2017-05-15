<?php
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <title>
        十三说
    </title>
    <style>
        body{font-size: 14px;line-height: 1.5;color: #444;}
        ul, ol, li, dl, dd {
            margin: 0;
            padding: 0;
        }
        div {
            display: block;
            margin: 0;
            padding: 0;
            border: 0;
        }
        dt {
            display: block;
        }
        dl {
            display: block;
            -webkit-margin-before: 1em;
            -webkit-margin-after: 1em;
            -webkit-margin-start: 0px;
            -webkit-margin-end: 0px;
        }
        a, a:active, a:hover, a:focus, a:visited {
            text-decoration: none;
        }
        .title{border-top: 1px solid #eeebeb;border-bottom: 1px solid #eeebeb;}
        .title h2 {border-left: 4px solid #c01e2f;padding-left: 6px;font-size: 16px;font-style: normal;line-height: 34px;height: 34px;color: #c01e2f;font-weight: 400;margin: 0;}
        .reply-list{
            position: relative;
            padding: 10px;
        }
        .reply-list .operations-user {
            display: -webkit-box;
            display: -ms-flexbox;
            display: -webkit-flex;
            display: -moz-flex;
            display: flex;
        }
        .reply-list .user-avatar {
            position: relative;
            width: 30px;
            height: 30px;
            overflow: hidden;
            margin: 5px 8px 0 0;
            border-top-left-radius: 999px;
            border-top-right-radius: 999px;
            border-bottom-right-radius: 999px;
            border-bottom-left-radius: 999px;
            border-radius: 999px;
            background-clip: padding-box;
        }
        .reply-list .user-avatar img {
            width: 100%;
            height: 100%;
            border-top-left-radius: 999px;
            border-top-right-radius: 999px;
            border-bottom-right-radius: 999px;
            border-bottom-left-radius: 999px;
            border-radius: 999px;
            background-clip: padding-box;
            border: 0;
            vertical-align: middle;
        }
        .reply-list .user-avatar .mask {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            width: 100%;
            height: 100%;
            z-index: 2;
            border-top-left-radius: 999px;
            border-top-right-radius: 999px;
            border-bottom-right-radius: 999px;
            border-bottom-left-radius: 999px;
            border-radius: 999px;
            background-clip: padding-box;
        }
        .user-info {flex: 1;-webkit-box-flex: 1;}
        .reply-list .user-other {
            font-size: 12px;
            color: #a9a9b2;
        }
        .button-light{
            color: #abaeb2;
            background: transparent;
            text-decoration: none;
        }
        .reply-content{
            padding: 7px 0 0 38px;
        }
        .reply-list:after {
            content: "";
            position: absolute;
            left: 0;
            bottom: 0;
            width: 100%;
            height: 1px;
            overflow: hidden;
            background-image: -webkit-linear-gradient(top,#e8e8e8,#e8e8e8 60%,transparent 60%);
            background-size: 100% 1px;
            background-position: bottom;
            background-repeat: no-repeat;
        }
        .clearfix:after {
            display: block;
            clear: both;
            content: "";
            visibility: hidden;
            height: 0;
        }
        .m_article {
            font-size: .24rem;
            padding: .2rem 0;
            border-bottom: 1px solid #e5e5e5;
            margin: 0 .3rem;
            padding-top: 10px;
        }
        .m_article:last-child{border:none}
        .m_article .m_article_img {
            float: left;
            width: 27%;
            height: 11%;
            overflow: hidden;
            position: relative;
            margin-right: .2rem;
        }
        .m_article .m_article_img img {
            width: 100%;
            display: block;
            min-height: 1.4rem;
        }
        .m_article .m_article_info {
            overflow: hidden;
            padding-bottom: 4px;
        }
        .m_article .m_article_info .m_article_title {
            font-size: 1rem;
            margin-bottom: .2rem;
            color: #404040;
            line-height: 1.42rem;
            width: 100%;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            overflow: hidden;
            -webkit-line-break: auto;
            -webkit-box-orient: vertical;
        }
        .m_article .m_article_desc .m_article_desc_l {
            float: left;
        }
        .m_article .m_article_desc .m_article_time {
            font-size: .24rem;
            color: #888888;
            display: inline-block;
        }
        .m_article .m_article_desc .m_article_desc_r {
            float: right;
            background-size: contain;
            background-position: left 0;
            background-repeat: no-repeat;
            color: #888888;
            line-height: .37rem;
        }
        .m_article .m_article_desc .m_article_desc_r .iconfont {
            padding: 6px .1rem 0 0;
            display: inline-block;
            font-size: .28rem;
            color: #a8a8a8;
        }
        .iconfont {
            font-family: "iconfont" !important;
            font-size: 16px;
            font-style: normal;
            -webkit-font-smoothing: antialiased;
            -webkit-text-stroke-width: .2px;
            -moz-osx-font-smoothing: grayscale;
        }
    </style>
</head>
<body>
    <div class="content">
        <h2 class="rich_media_title" id="activity-name" style="margin: 0px 0px 5px; padding: 0px; font-weight: 400; font-size: 24px; line-height: 1.4; zoom: 1;"><?= $model->title; ?></h2>
        <p>
            <span id="post-date"  style="margin: 0px 8px 10px 0px; padding: 0px; display: inline-block; vertical-align: middle; font-size: 14px; color: rgb(153, 153, 153); max-width: none;"><?= date("Y-m-d",$model->created_at); ?></span>&nbsp;
            <span style="margin: 0px 8px 10px 0px; padding: 0px; display: inline-block; vertical-align: middle; font-size: 14px; color: rgb(153, 153, 153); max-width: none;"><?= $username; ?></span>
        </p>
    <?= $model->content;?>
    </div>
    <!--相关-->
    <div class="title">
        <h2>相关推荐</h2>
    </div>
    <div class="relative_list js-relativelist">
        <div class="m_article clearfix">
            <a href="#">
                <div class="m_article_img">
                    <img src="http://dmr.nosdn.127.net/mBhpAxawPCFwzFlStsmp3A==/6896093022947228255.jpg?imageView&amp;thumbnail=220y165&amp;quality=85&amp;type=webp&amp;interlace=1&amp;enlarge=1">
                </div>
                <div class="m_article_info">
                    <div class="m_article_title">
                        <span>【科普】糖尿病怎么防？怎么治？</span>
                    </div>
                    <div class="m_article_desc clearfix">
                        <div class="m_article_desc_l">
                            <span class="m_article_time">3天前</span>
                        </div>
                        <div class="m_article_desc_r">
                            <div class="left_hands_desc">
                                <span class="iconfont"></span>0
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="m_article clearfix">
            <a href="#">
                <div class="m_article_img">
                    <img src="http://dmr.nosdn.127.net/mBhpAxawPCFwzFlStsmp3A==/6896093022947228255.jpg?imageView&amp;thumbnail=220y165&amp;quality=85&amp;type=webp&amp;interlace=1&amp;enlarge=1">
                </div>
                <div class="m_article_info">
                    <div class="m_article_title">
                        <span>【科普】糖尿病怎么防？怎么治？</span>
                    </div>
                    <div class="m_article_desc clearfix">
                        <div class="m_article_desc_l">
                            <span class="m_article_time">3天前</span>
                        </div>
                        <div class="m_article_desc_r">
                            <div class="left_hands_desc">
                                <span class="iconfont"></span>0
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <!--评论-->
    <div class="title">
        <h2>评论</h2>
    </div>
    <div class="reply-inner">
        <dl class="reply-list">
            <dd class="operations-user">
                <div class="user-avatar">
                    <img src="picture/20179937-1492306614.jpg@45h_45w_2e" alt="">
                    <span class="mod-mask mask"></span>
                </div>
                <div class="user-info">
                    <div class="user-name">姚终生火箭球迷</div>
                    <div class="user-other">
                        <span class="times">39分钟前</span>
                    </div>
                </div>
                <div class="operations">
                    <a href="javascript:" class="button-light">
                        赞(56)</a>
                </div>
            </dd>
            <dt class="reply-content" style="font-size:16px;">
            <div class="current-content J_contentParent J_currentContent">
                <span class="short-content">
                雷霆劈扣，一下子又回到了雷霆三少的那个年代。
                </span>
            </div>
            </dt>
        </dl>
    </div>
    </div>
</body>
</html>

