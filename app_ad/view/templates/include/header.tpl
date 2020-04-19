<!DOCTYPE html>
<html lang="ja">
<head>
<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
<meta charset="utf-8">
<meta name="keywords" content="家計簿記, 家計簿, 簿記、複式簿記" >
<meta name="description" content="簿記のように家計簿をつけながら経済に強くなるアプリです。">
<title>{$title} | 家計簿記</title>
<link type="text/css" rel="stylesheet" href="/kakeiboki/app/assets/css/style.css">
<link type="text/css" rel="stylesheet" href="/kakeiboki/app/assets/lib/font-awesome.min.css">
</head>
<body>
  <div id="wrapper">
    <header id="header">
      <div class="header-inner clearfix">
        <h1 class="logo">
        {if $top|default:false == true}
          <a href="./">家計簿記</a>
        {else}
          <a href="../">家計簿記</a>
        {/if}
        </h1>
        <nav class="gnav">
          <ul>
            {if $status|default:false == 'login'}
            <li><a href="../reply/list">返信一覧</a></li>
            <li><a href="../login/logout">ログアウト</a></li>
            {elseif $status|default:false == 'no_login_error'}
            <li><a href="../">ログイン</a></li>
            {/if}
            <li><a href="#">ヘルプ</a></li>
          </ul>
        </nav>
      </div>
    </header>