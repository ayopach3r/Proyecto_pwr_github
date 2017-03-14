<?php
// Routes

$app->get('/', function ($request, $response, $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.php', $args);
})->setName('Inicio');

$app->get('/acercade', function ($request, $response, $args) {
    // Sample log message
    $this->logger->info("Vista acerca de");

    // Render index view
    return $this->renderer->render($response, 'acercade.php', $args);
})->setName('Acerca_de');

$app->get('/upload', function ($request, $response, $args) {
    // Sample log message
    $this->logger->info("Aqui se haran los uploads");

    // Render index view
    return $this->renderer->render($response, 'upload.php', $args);
})->setName('Upload');

$app->get('/login', function ($request, $response, $args) {
    // Sample log message
    $this->logger->info("Aqui se haran los login");

    // Render index view
    return $this->renderer->render($response, 'login.php', $args);
})->setName('Login');

$app->get('/logout', function ($request, $response, $args) {
    // Sample log message
    $this->logger->info("Aqui se haran los logout");

    // Render index view
    return $this->renderer->render($response, 'logout.php', $args);
})->setName('Logout');

//Agregar ficheros
$app->get('/agregarFichero', function ($request, $response, $args) {
    // Render index view
    return $this->renderer->render($response, 'agregarFichero.php', $args);
});

$app->post('/agregarFichero', function ($request, $response, $args) {
    $fichero=$request->getParam('ficheroichero');
    //<input type="file">
    if($_FILES[$fichero]['error']==0){
        if($_FILES[$fichero]['type']=='text/xml'){

        }elseif ($_FILES[$fichero]['type']=='text/csv') {
            
        }else{
            //error
        }
    }
    return $this->renderer->render($response, 'agregarFicheroError.php', $args);
     
});

