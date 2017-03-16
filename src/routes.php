<?php
// Routes
$aln = new Alumnos();
$lcn = new Licencias();
$prof = new Profesores();
$model = new Modelo();


$app->get('/', function ($request, $response, $args) use($model,$lcn,$aln) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");
    $data= array('alumnos' => $model->ObtenerAlumnos(),
        'alumno' => $aln);
    // Render index view
    return $this->view->render($response,'index.php',$data);
})->setName('Inicio');

$app->get('/acercade', function ($request, $response, $args) use ($app){
    $fecha = date('l dS \o\f F Y h:i:s A');
    $data = array('nombre' => 'Ayoze Pacheco y Gustavo Lopez Garcia',
                  'descripcion' => 'Aplicacion orientada a la adminitración de licencias para alumnos por parte de los profesores', 
                  'fecha' =>$fecha);
    $body = $this->view->fetch('acercade.twig.php', $data);
    return $response->write($body); 
})->setName('Acerca_de');

$app->get('/login', function ($request, $response, $args) {
    // Sample log message
    $this->logger->info("Aqui se haran los login");

    // Render index view
    return $this->view->render($response,'login.twig.php');
})->setName('Login');

$app->get('/logout', function ($request, $response, $args) {
    // Sample log message
    $this->logger->info("Aqui se haran los logout");

    // Render index view
    return $this->view->render($response,'logout.twig.php');
})->setName('Logout');

$app->get('/upload', function ($request, $response, $args) {
    // Sample log message
    $this->logger->info("Aqui se haran los uploads");

    // Render index view
    return $this->view->render($response,'upload.twig.php');
})->setName('Upload');

$app->post('/upload', function ($request, $response, $args)  use ($aln, $model, $prof, $lcn){
    //<input type="file">
    if($_FILES['fichero']['error']==0){

        $nombre=$_FILES['fichero']['name'];
        $tamanio = $_FILES['fichero']['size'];
        $temporal= $_FILES['fichero']['tmp_name'];
        $subidos= "C:\wamp64\www\Proyecto_pwr_github\icheros_subidos";
        
        //copy($temporal,$subidos);

        if($_FILES['fichero']['type']=='text/xml'){
            $documento= simplexml_load_file('C:\wamp64\www\Proyecto_pwr_github\keysW7.xml');
             foreach ($documento->Product_Key->Key as $k) {
                  $lcn->__SET('nombre',$documento->Product_Key['Name']);
                  //$lcn-> __SET('nombre',(string)$k['Name']); 
                  $lcn->__SET('clave',(string)$k);
                  $lcn->__SET('ref_tipo_licencia',2);
                  if($model->ComprobarLicencias($lcn)==false){
                        $model->AñadirLicencias($lcn);
                  }
               }  
        }elseif ($_FILES['fichero']['type']=='text/csv') {
            $archivotmp = $_FILES['fichero']['tmp_name'];
            //cargamos el archivo
            $lineas = file("C:\wamp64\www\Proyecto_pwr_github\'.$nombre.'");

            $i=0;
 
            //Recorremos el bucle para leer línea por línea
            foreach ($lineas as $linea_num => $linea)
            { 
               //abrimos bucle
               /*si es diferente a 0 significa que no se encuentra en la primera línea 
               (con los títulos de las columnas) y por lo tanto puede leerla*/
               if($i != 0) 
               { 
                   //abrimos condición, solo entrará en la condición a partir de la segunda pasada del bucle.
                   /* La funcion explode nos ayuda a delimitar los campos, por lo tanto irá 
                   leyendo hasta que encuentre un ; */
                   $datos = explode(";",$linea);
             
                   //Almacenamos los datos que vamos leyendo en una variable;

                  $prof-> __SET('ref_departamento',$datos[0]); 
                  $prof-> __SET('dni',$datos[1]);
                  $prof-> __SET('nombre',$datos[2]);
                  $prof-> __SET('primer_apellido',$datos[3]); 
                  $prof-> __SET('segundo_apellido',$datos[4]);
                  $prof-> __SET('telefono',$datos[5]);
                  $prof-> __SET('email',$datos[7]);
                  $prof-> __SET('email',$datos[9]);     
                  $model->AñadirProfesores($prof);
               }
             
               /*Cuando pase la primera pasada se incrementará nuestro valor y a la siguiente pasada ya 
               entraremos en la condición, de esta manera conseguimos que no lea la primera línea.*/
               $i++;
               //cerramos bucle
            }
        }else{
            //errorvdvd
        }
        return $this->view->render($response,'upload.twig.php');
    }
    
});

