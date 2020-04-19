<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8" >
<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
<meta name="keywords" content="家計簿記, 家計簿, 簿記、複式簿記" >
<meta name="description" content="簿記のように家計簿をつけながら経済に強くなるアプリです。" >
<title>{$title} | 家計簿記</title>
<link type="text/css" rel="stylesheet" href="{$systemRoot}/assets/css/style.css">
{if $css_font|default:false == true}
<link type="text/css" rel="stylesheet" href="{$systemRoot}/assets/lib/jquery-ui/jquery-ui.min.css">
<link type="text/css" rel="stylesheet" href="{$systemRoot}/assets/lib/font-awesome.min.css">
{/if}
{include file="include/analytics.tpl"}
</head>
<body>
  <div id="wrapper">
    <header id="header">
      <div class="header-inner clearfix">
        <h1 class="logo">
          <a href="{$systemRoot}/">家計簿記</a>
        </h1>
        {if isset($login_user_name) == true}
        <div class="l-header-user">ようこそ {$login_user_name}さん</div>
        {/if}
        <nav class="gnav">
          <ul>
            {if $toppage|default:false == 'true'}
            <li><a href="{$systemRoot}/signup/">新規登録</a></li>
            {/if}
            {if $gnav|default:false == 'outer'}
            <li><a href="{$systemRoot}/signup/">新規登録</a></li>
            <li><a href="{$systemRoot}/">ログイン</a></li>
            {elseif $gnav|default:false == 'inner'}
            <li id="js-gmenu-trigger"><a href="#">メニュー</a></li>
            <li><a href="{$systemRoot}/login/logout">ログアウト</a></li>
            <li><a href="{$systemRoot}/resign/">退会</a></li>
            {/if}
            <li><a href="{$systemRoot}/#">ヘルプ</a></li>
          </ul>
        </nav>
      </div>
    </header>