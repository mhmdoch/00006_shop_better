<!doctype html>
<html class="no-js h-100" lang="de">
    <head>
        <meta property="og:type" content="article" />

        <x-zubzet::head :opt="$opt"/>
        @yield("head")
    </head>
    <body class="h-100" id="top">
        @yield("content")
        <x-zubzet::body :opt="$opt"/>
    </body>
</html>
