<!doctype html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="/css/style.css" >

    <title><?= $title; ?> | Football Tips</title>
  </head>
  <body style="background-color: #cccccc;">

    <header>
      <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <a class="navbar-brand" href="/">Football Tips</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item">
              <a class="nav-link" href="/mytips">Meine Tipps</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/bestlist">Bestenliste</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/user">Benutzer</a>
            </li>
          </ul>
        </div>
      </nav>
    </header>

    <main class="container">
      <h1><?= $heading; ?></h1>
      <div style="background-color: #ffffff; padding: 2% 2% 0 2%">
