<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$title}} - Teramedik Screening</title>
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="/assets/css/sweetalert.min.css">
    <script src="/assets/js/sweetalert.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa; 
        }

        .navbar {
            background-color: #343a40; 
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }

        .navbar-brand {
            color: #fff;
            font-size: 1.5rem;
            font-weight: bold;
        }

        .navbar-nav .nav-link {
            color: #adb5bd; 
            padding: 0.75rem 1.25rem;
            transition: background-color 0.15s ease-in-out, color 0.15s ease-in-out;
        }

        .navbar-nav .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: #fff;
        }

        .navbar-nav .nav-link.active {
            background-color: #007bff; 
            color: #fff;
            border-radius: 0.25rem;
        }

        .navbar-nav .nav-item {
            margin-left: 0.5rem;
        }

        .navbar-nav .nav-item:first-child {
            margin-left: 0;
        }

        .navbar-nav .nav-link i {
            margin-right: 0.5rem;
        }

        .navbar {
            background: linear-gradient(to right, #343a40, #212529);
        }

        .dropdown-menu {
            background-color: #343a40;
            border: none;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
        }

        .dropdown-item {
            color: #adb5bd;
            transition: background-color 0.15s ease-in-out, color 0.15s ease-in-out;
        }

        .dropdown-item:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: #fff;
        }

        .dropdown-divider {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }
    </style>
</head>
<body>