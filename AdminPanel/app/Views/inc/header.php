<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<meta name="Description" content="CodeIgniter 4 CRUD tutorial"/>
<title>SlashRTC</title>
    <!-- CSS files -->
    <link rel="stylesheet" href="<?php echo base_url('/public/assets/css/googleapis1.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('/public/assets/css/googleapis2.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('/public/assets/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('/public/assets/css/bootstrap-reboot.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('/public/assets/css/bootstrap-grid.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('/public/assets/css/bootstrap.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('/public/assets/css/bootstrap.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('/public/assets/chatApp.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('/public/assets/css/dataTables.dataTables.min.css')?>">
    <link rel="stylesheet" href="<?php echo base_url('/public/assets/css/header.css')?>">

    <!-- JS files -->
    <script src="<?php echo base_url('/public/assets/js/bootstrap.bundle.min.js'); ?>"></script>
    <script src="<?php echo base_url('/public/assets/js/bootstrap.min.js'); ?>"></script>
    <script src="<?php echo base_url("/public/assets/js/jquery-3.6.0.min.js")?>" ></script>
    <script src="<?php echo base_url('/public/assets/js/dataTables.min.js');?>" ></script>
     <script src="<?php echo base_url('/public/assets/js/dataTables.min.js');?>" ></script>
     <script src="<?php echo base_url('/public/assets/js/bootstrapcdn3.js');?>" ></script>
     <script src="<?php echo base_url('/public/assets/js/popper.main..js');?>" ></script>



</head>
<body>
<nav class="navbar navbar-expand-lg bg-dark navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="<?php echo site_url(); ?>">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo site_url('register');?>">Register</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo site_url('login'); ?>">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo site_url('logOut'); ?>">Log Out</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo site_url('campaign'); ?>">Campaign</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo site_url('chat'); ?>">Chat</a>
                    </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="databaseDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
                        Select Report Type
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="databaseDropdown">
                        <li><a class="dropdown-item" href="<?php echo site_url('report_sql'); ?>">SQL</a></li>
                        <li><a class="dropdown-item" href="<?php echo site_url('report_mongo'); ?>">MongoDB</a></li>
                        <li><a class="dropdown-item" href="<?php echo site_url('report_elastic'); ?>">Elasticsearch</a></li>
                    </ul>
                </li>
                </ul>
                <div class="user-profile">
            <?php if (session()->get('user')): ?>
                <span style="color: white;"><?php echo session()->get('user')['name']; ?></span>
                <div class="avatar"><?php echo strtoupper(substr(session()->get('user')['name'], 0, 1)); ?></div>
                <!-- <a href="<?php echo base_url('login/logout'); ?>" class="logout-button">Logout</a> -->
            <?php else: ?>
                <span style="color: white;">Guest</span>
                <div class="avatar" style="color: black;">G</div>
            <?php endif; ?>
        </div>
            </div>
    </nav>
    <header class="navbar">
        <nav>
            <ul>
                <li>Live</li>
                <li>Reports</li>
                <li>Conversations</li>
                <li>Contacts</li>
                <li>Operations</li>
                <li>Advanced Settings</li>
            </ul>
        </nav>
    </header>