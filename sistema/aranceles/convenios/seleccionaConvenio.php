<?
/// NO USAR DIRECTAMENTE SOLO DENTRO DE UN SERVIDOR PHP
//// EJEMPLO USANDO CORS!!
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");
/// CONECTA A LA BASE DE DATOS	
// Create connection
// reemplazar con ("localhost", USUARIO, PASSWORD, NOMBRE_DE_BASE_DE_DATOS)
include('../../../php/coneccion.php');

$id = $_GET['id'];

$result = mysqli_query($conexion,"SELECT OBSOLETO, PRECIO, IDCONVENIO, INSTITUCION, NOMCONVENIO from convenios, origen
                                  WHERE IDCONVENIO = '$id'
                                  AND convenios.IDORIGEN = origen.IDORIGEN");



/// crea un arreglo general vacio

$objetoConvenio = array();
$objetoConvenio["labores"] = array();
// el arreglo se popula en este bucle

$row = mysqli_fetch_array($result);

    $objetoConvenio["id"] = $row['IDCONVENIO'];
    $objetoConvenio["nombre"] = $row['NOMCONVENIO'];	
    $objetoConvenio["precio"] = $row['PRECIO'];
    $objetoConvenio["origen"] = $row['INSTITUCION'];	
    $objetoConvenio["obsoleto"] = $row['OBSOLETO'];	
    
    
/// inserta el objeto con los datos de registro, dentro del arreglo general
    
    
    $result2 = mysqli_query($conexion,"SELECT DESCRIPCION, NOMETAPA from infoconvenio, labores, etapas
                                  WHERE IDCONVENIO = '$id'
                                  AND infoconvenio.IDLABOR = labores.IDLABOR
                                  AND labores.IDETAPA = etapas.IDETAPA");



while ($row2 = mysqli_fetch_array($result2)){
       $objetoLabor = array();
    // crea un objeto donde se incluyen los datos del registro
       $objetoLabor["labor"] = $row2['DESCRIPCION'];
       $objetoLabor["etapa"] = $row2['NOMETAPA'];
    
       array_push($objetoConvenio["labores"], $objetoLabor); 
    
}   

echo json_encode($objetoConvenio);
 
/// una vez populado el arreglo general con datos, se convierte a Json

	
	
?>