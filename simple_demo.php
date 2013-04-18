<?php
/**
 * Archivo de ejemplo sobre ejecucion de Firebug para depurar codigo en PHP
 * @author Gaston Nina <gastonnina@gmail.com>
 */
# llamada a la libreria de Firebug PHP
require_once('FirePHPCore/fb.php');

# El primer parametro que resive puede ser un String, entero, array multi nivel
# El segundo parametro es una etiqueta a modo de label
# El tercer parametro indica de que forma se mostrara nuestro mensaje en el ejemplo usamos INFO, pero este puede ser ERROR, ALERT
$key = 0;
fb($key, 'Key', FirePHP::INFO);
$comment = 'Hola Mundo';
fb($comment, FirePHP::INFO);
# obtiene todas las variables GET
fb($_GET, 'GET', FirePHP::INFO);
$categoria = array(
    'array1' => array(
        'array1_1' => array(
            'array1_1_1', 
            'array1_1_2' => 112, 
            'array1_1_3' => 'contenido'
            )), 
    'array2' => array('array2_1' => 0), 
    'array3');
fb($categoria, 'Arbol de Familia', FirePHP::INFO);

# Este manejara todo nuestro entorno
fb(array('p' => $_POST, 'g' => $_GET), 'Entorno', FirePHP::INFO);

# Este array se convertira en tabla
# en el proposito es mostrar los queries ejecutados para cargar la pagina y el tiempo de ejecucion de cada uno y numero de registros
# OJO - como para el ejemplo no se creo base de datos simulamos 2 registros
/**/
# estas globales deberian de declararse en el config de su sitio
global $bandera, $allQuery;
$bandera = 1; // bandera nos ayudara a pasar de desarrollo a produccion
$allQuery = array();
$sql = "SELECT * FROM tabla1 WHERE public=1";
$timeProcess = 0.000065;
$totRows = 50;
$allQuery[] = array("sql" => $sql, "time" => $timeProcess, 'totRows' => $totRows);
$sql = "SELECT * FROM tabla1 t1 INNER JOIN tabla2 t2 ON (t1.id_tabla1=t2.fid_tabla2) WHERE t1.public=1 ORDER BY t1.nombre ASC";
$timeProcess = 0.00022;
$totRows = 100;
$allQuery[] = array("sql" => $sql, "time" => $timeProcess, 'totRows' => $totRows);
/**/

# ejecutamos el la funcion creada para que muestre los datos
fireShowSqls();

/**
 * Funcion que muestra en Firebug Tabla de queries Ejecutados
 * Necesita tener FirebugPHP instalado en Firefox
 * FirePHP::TABLE
 * @author Gaston Nina <gastonnina@gmail.com>
 */
function fireShowSqls() {
    global $bandera, $allQuery;
    if ($bandera) {
        $qy_time = 0;
        $qy_arr = array();
        $qy_arr[] = array('Num', 'Total Rows', 'Time', 'SQL Statement');
        $qy_c = 0;
        foreach ($allQuery as $qy) {
            $qy_time+=$qy['time'];
            $qy_arr[] = array(++$qy_c, $qy['totRows'], round($qy['time'], 5), $qy['sql']);
        }
        fb(array(count($allQuery) . ' SQL queries took ' . ($qy_time) . ' seconds', $qy_arr), FirePHP::TABLE);
    }
}
?>
<html>
    <head>
        <title>Ejemplo de FirePhp</title>
    </head>        
    <body>
        <h1>Ejemplo básico de FirePHP</h1>
        <p>Debe tener FirePhp instalado para poder apreciar el ejemplo dirigase alsiguiente post para mas datos 
            <a href="link" title="Codigo Base - Firebug">POST de ejemplo Firebug PHP</a>
        </p>
    </body>
</html>