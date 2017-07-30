<?
    include_once dirname(__FILE__) . "/../loader.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><? echo $title ?></title>
    <link href="<? echo URL ?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<? echo URL ?>assets/css/style.min.css" rel="stylesheet">
    <link href="<? echo URL ?>assets/img/favicon.ico" rel="shortcut icon">

    <link rel="stylesheet" href="<? echo URL ?>assets/js/trumbowyg/ui/trumbowyg.min.css">
    <link rel="stylesheet" href="<? echo URL ?>assets/js/trumbowyg/plugins/colors/ui/trumbowyg.colors.min.css">

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <style>
        body {
            color: #333;
            background: #fff;
        }

        .modal-header, .modal-body, .modal-footer {
            color: #000000;
        }

        .navbar-default {
            background-color: #d9534f;
            border-color: #d9534f;
            text-transform: uppercase;
        }

        .navbar-default .navbar-nav > li > a {
            color: #fff;
        }

        .navbar-default .navbar-nav > li > a:hover, .navbar-default .navbar-nav > li > a:focus {
            color: #fff;
            text-decoration: underline;
        }

        .navbar-default .navbar-nav > .active > a, .navbar-default .navbar-nav > .active > a:hover, .navbar-default .navbar-nav > .active > a:focus {
            color: #fff;
        }

        .navbar-default .navbar-toggle {
            border-color: transparent;
        }

        .navbar-default .navbar-toggle:hover, .navbar-default .navbar-toggle:focus {
            background-color: transparent;
        }

        .navbar-default .navbar-toggle .icon-bar {
            background-color: #fff;
        }

        .navbar-default .navbar-collapse, .navbar-default .navbar-form {
            border: 0;
        }

        .panel {
            background-color: #fafafa;
            border-color: #4582ec;
        }

        .panel .panel-heading {
            color: #fff;
            text-transform: uppercase;
            background-color: #4582ec;
            border: 0;
        }

        .progress {
            background-color: #eee;
        }

        .module .payments li {
            border-color: #eee;
        }

        .table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
            border-color: #eee;
        }

        .table-striped > tbody > tr:nth-child(odd) > td, .table-striped > tbody > tr:nth-child(odd) > th {
            background-color: #eee;
        }

        .text-primary {
            color: #4582ec;
        }

        .text-primary:hover {
            color: #1863e6;
        }

        a {
            color: #d9534f;
            text-decoration: none;
        }

        a:hover, a:focus {
            color: #b52b27;
            text-decoration: underline;
        }

        a:focus {
            outline: thin dotted;
            outline: 5px auto -webkit-focus-ring-color;
            outline-offset: -2px;
        }

        a.thumbnail:hover, a.thumbnail:focus, a.thumbnail.active {
            border-color: #d9534f;
        }

        .btn-link {
            color: #d9534f;
            font-weight: normal;
            cursor: pointer;
            border-radius: 0;
        }

        .btn-link, .btn-link:active, .btn-link[disabled], fieldset[disabled] .btn-link {
            background-color: transparent;
            -webkit-box-shadow: none;
            box-shadow: none;
        }

        .btn-link, .btn-link:hover, .btn-link:focus, .btn-link:active {
            border-color: transparent;
        }

        .btn-link:hover, .btn-link:focus {
            color: #b52b27;
            text-decoration: underline;
            background-color: transparent;
        }

        .btn-link[disabled]:hover, fieldset[disabled] .btn-link:hover, .btn-link[disabled]:focus, fieldset[disabled] .btn-link:focus {
            color: #999999;
            text-decoration: none;
        }

        .dropdown-menu > .active > a, .dropdown-menu > .active > a:hover, .dropdown-menu > .active > a:focus {
            color: #ffffff;
            text-decoration: none;
            outline: 0;
            background-color: #4582ec;
        }

        .nav-pills > li {
            float: left;
        }

        .nav-pills > li > a {
            border-radius: 4px;
        }

        .nav-pills > li + li {
            margin-left: 2px;
        }

        .nav-pills > li.active > a, .nav-pills > li.active > a:hover, .nav-pills > li.active > a:focus {
            color: #ffffff;
            background-color: #4582ec;
        }

        .nav-pills > li.active > a .caret, .nav-pills > li.active > a:hover .caret, .nav-pills > li.active > a:focus .caret {
            border-top-color: #ffffff;
            border-bottom-color: #ffffff;
        }

        a.list-group-item {
            color: #555555;
        }

        a.list-group-item .list-group-item-heading {
            color: #333333;
        }

        a.list-group-item:hover, a.list-group-item:focus {
            text-decoration: none;
            background-color: #f5f5f5;
        }

        a.list-group-item.active, a.list-group-item.active:hover, a.list-group-item.active:focus {
            z-index: 2;
            color: #ffffff;
            background-color: #4582ec;
            border-color: #4582ec;
        }

        a.list-group-item.active .list-group-item-heading, a.list-group-item.active:hover .list-group-item-heading, a.list-group-item.active:focus .list-group-item-heading {
            color: inherit;
        }

        a.list-group-item.active .list-group-item-text, a.list-group-item.active:hover .list-group-item-text, a.list-group-item.active:focus .list-group-item-text {
            color: #fefeff;
        }

        .btn-primary {
            color: #ffffff;
            background-color: #4582ec;
            border-color: #2e72ea;
        }

        .btn-primary:hover, .btn-primary:focus, .btn-primary:active, .btn-primary.active, .open .dropdown-toggle.btn-primary {
            color: #ffffff;
            background-color: #1863e6;
            border-color: #1455c6;
        }

        .btn-primary:active, .btn-primary.active, .open .dropdown-toggle.btn-primary {
            background-image: none;
        }

        .btn-primary.disabled, .btn-primary[disabled], fieldset[disabled] .btn-primary, .btn-primary.disabled:hover, .btn-primary[disabled]:hover, fieldset[disabled] .btn-primary:hover, .btn-primary.disabled:focus, .btn-primary[disabled]:focus, fieldset[disabled] .btn-primary:focus, .btn-primary.disabled:active, .btn-primary[disabled]:active, fieldset[disabled] .btn-primary:active, .btn-primary.disabled.active, .btn-primary[disabled].active, fieldset[disabled] .btn-primary.active {
            background-color: #4582ec;
            border-color: #2e72ea;
        }

        .btn-primary .badge {
            color: #4582ec;
            background-color: #ffffff;
        }

        .pagination {
            display: inline-block;
            padding-left: 0;
            margin: 20px 0;
            border-radius: 4px;
        }

        .pagination > li {
            display: inline;
        }

        .pagination > li > a, .pagination > li > span {
            position: relative;
            float: left;
            padding: 6px 12px;
            line-height: 1.42857143;
            text-decoration: none;
            background-color: #ffffff;
            border: 1px solid #dddddd;
            margin-left: -1px;
        }

        .pagination > li:first-child > a, .pagination > li:first-child > span {
            margin-left: 0;
            border-bottom-left-radius: 4px;
            border-top-left-radius: 4px;
        }

        .pagination > li:last-child > a, .pagination > li:last-child > span {
            border-bottom-right-radius: 4px;
            border-top-right-radius: 4px;
        }

        .pagination > li > a:hover, .pagination > li > span:hover, .pagination > li > a:focus, .pagination > li > span:focus {
            background-color: #eeeeee;
        }

        .pagination > .active > a, .pagination > .active > span, .pagination > .active > a:hover, .pagination > .active > span:hover, .pagination > .active > a:focus, .pagination > .active > span:focus {
            z-index: 2;
            color: #ffffff;
            background-color: #4582ec;
            border-color: #4582ec;
            cursor: default;
        }

        .pagination > .disabled > span, .pagination > .disabled > span:hover, .pagination > .disabled > span:focus, .pagination > .disabled > a, .pagination > .disabled > a:hover, .pagination > .disabled > a:focus {
            color: #999999;
            background-color: #ffffff;
            border-color: #dddddd;
            cursor: not-allowed;
        }

        .label-primary {
            background-color: #4582ec;
        }

        .label-primary[href]:hover, .label-primary[href]:focus {
            background-color: #1863e6;
        }

        .progress-bar {
            background-color: #4582ec;
        }

        .panel-primary {
            border-color: #4582ec;
        }

        .panel-primary > .panel-heading {
            color: #ffffff;
            background-color: #4582ec;
            border-color: #4582ec;
        }

        .panel-primary > .panel-heading + .panel-collapse > .panel-body {
            border-top-color: #4582ec;
        }

        .panel-primary > .panel-footer + .panel-collapse > .panel-body {
            border-bottom-color: #4582ec;
        }
    </style>

    <style>
        .panel-heading {
            padding-top: 10px;
            height: 45px;
            line-height: 25px;
        }

        .panel-heading .btn {
            margin-top: -5px;
        }

        .panel-seperator {
            border-top: 1px solid #dddddd;
            border-radius: 0;
            -moz-border-radius: 0;
            -webkit-border-radius: 0;
        }

        .package-image .image {
            width: 190px;
            height: 160px;
            margin: 5px auto 20px auto;
            border: 1px solid #D6D5D4;
            background: url(/assets/img/empty.png) no-repeat center;
        }

        .package-commands, .package-commands li {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .package-commands .advanced {
            display: none;
            padding: 10px;
        }

        .affix {
            top: 20px;
        }

    </style>

    <!--Start of Zopim Live Chat Script-->
    <script type="text/javascript">
        window.$zopim || (function (d, s) {
            var z = $zopim = function (c) {
                z._.push(c)
            }, $ = z.s =
                d.createElement(s), e = d.getElementsByTagName(s)[0];
            z.set = function (o) {
                z.set.
                _.push(o)
            };
            z._ = [];
            z.set._ = [];
            $.async = !0;
            $.setAttribute("charset", "utf-8");
            $.src = "//v2.zopim.com/?37utPsEcHWL1NbiigHiMuZtiJljbQt4V";
            z.t = +new Date;
            $.
                type = "text/javascript";
            e.parentNode.insertBefore($, e)
        })(document, "script");
    </script>
    <!--End of Zopim Live Chat Script-->
</head>
<body>
<div class="container">

    <? if ($inc_header)
    { ?>
        <nav class="navbar navbar-default" role="navigation">
            <div class="navbar-header">

                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Brand</a>
            </div>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li class="active">
                        <a href="#">Link</a>
                    </li>
                    <li>
                        <a href="#">Link</a>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown<strong class="caret"></strong></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="#">Action</a>
                            </li>
                            <li>
                                <a href="#">Another action</a>
                            </li>
                            <li>
                                <a href="#">Something else here</a>
                            </li>
                            <li class="divider">
                            </li>
                            <li>
                                <a href="#">Separated link</a>
                            </li>
                            <li class="divider">
                            </li>
                            <li>
                                <a href="#">One more separated link</a>
                            </li>
                        </ul>
                    </li>
                </ul>

                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="#">Link</a>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown<strong
                                class="caret"></strong></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="#">Action</a>
                            </li>
                            <li>
                                <a href="#">Another action</a>
                            </li>
                            <li>
                                <a href="#">Something else here</a>
                            </li>
                            <li class="divider">
                            </li>
                            <li>
                                <a href="#">Separated link</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>

        </nav>
    <? } ?>

    <div class="notification"></div>
