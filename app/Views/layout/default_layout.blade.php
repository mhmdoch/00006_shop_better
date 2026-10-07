<!doctype html>
<html class="no-js">

<head>
    <x-zubzet::head :opt="$opt" />
    @yield("head")
    <link href="<?php $opt["generateResourceLink"]("assets/bootstrap-icons/bootstrap-icons.min.css"); ?>" rel="stylesheet">
    <link href="<?php $opt["generateResourceLink"]("assets/css/app.css"); ?>" rel="stylesheet">

</head>

<body id="top" data-test="dashboard-top">
    
    <x-navbar :opt="$opt"/>

    <div class="container py-5">
        <x-breadcrumb />

        @yield("content")
    </div>

    <x-zubzet::body :opt="$opt" />
</body>

</html>
