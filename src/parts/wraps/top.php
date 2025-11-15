<!DOCTYPE html>
<html lang="en">
<head class="flex-y">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?= $D['full_title'] ?? ("DoD - " . ($D['title'] ?? 'Untitled')) ?></title>
	<link rel="icon" type="image/png" href="/static/images/favicon.png">
	<link rel="stylesheet" href="/static/css/<?= $D['style'] ?? 'global' ?>.css">
</head>
<body class="flex-y">
<?php render('wraps/header') ?>
<main id="content" class="fill flex-y flex-o">
