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
$result = mysqli_query($conexion,"SELECT orden.IDORIGEN, 
                                         orden.IDODONTOLOGO,
                                         orden.PACIENTE, 
                                         orden.ADHERENTE, 
                                         orden.FECHARECEPCION,
                                         orden.FECHAENTREGA,
                                         orden.DESCUENTO,
                                         orden.TOTALORDEN,
                                         orden.ESTADO,
                                         orden.PAGADO,
                                         orden.ANULACION,
                                         
                                         colados.NUMCORONAS,
                                         colados.PIEZAS,
                                         colados.IDMETAL,
                                         colados.PESOMETAL,
                                         colados.TOTALMETAL
                                         
                                  FROM orden INNER JOIN colados
                                  ON orden.NUMORDEN = colados.NUMORDEN
                                  WHERE orden.NUMORDEN = '$id'
                                  AND orden.clasificacion =2");

/* LEFT JOIN convenios ON orden.IDCONVENIO = convenios.IDCONVENIO*/




/// crea un arreglo general vacio
// el arreglo se popula en este bucle
$row = mysqli_fetch_array($result);
    // crea un objeto donde se incluyen los datos del registro
    $objetoOrden = array();
    $objetoOrden["id"] = $id;
    $objetoOrden["origen"] = array();
    $objetoOrden["origen"]["id"] = $row['IDORIGEN'];
    $objetoOrden["odontologo"] = array();
    $objetoOrden["odontologo"]["id"] = $row['IDODONTOLOGO'];
    $objetoOrden["paciente"] = $row['PACIENTE'];
    $objetoOrden["comentario"] = $row['ADHERENTE'];
    $objetoOrden["inicio"] = $row['FECHARECEPCION'];
    $objetoOrden["fin"] = $row['FECHAENTREGA'];
    $objetoOrden["descuento"] = $row['DESCUENTO'];
    $objetoOrden["total"] = $row['TOTALORDEN'];
    $objetoOrden["totalOld"] = $row['TOTALORDEN'];
    $objetoOrden["estado"] = $row['ESTADO'];
    $objetoOrden["pagado"] = $row['PAGADO'];
    $objetoOrden["anulacion"] = $row['ANULACION'];
        
    $objetoOrden["colados"] = $row['NUMCORONAS'];
    $objetoOrden["piezas"] = $row['PIEZAS'];
    $objetoOrden["totalMetal"] = $row['TOTALMETAL'];
    $objetoOrden["totalMetalOld"] = $row['TOTALMETAL'];
    $objetoOrden["metal"] = array();
    $objetoOrden["metal"]["id"] = $row['IDMETAL'];
    $objetoOrden["pesoMetal"] = $row['PESOMETAL'];

        
        
    
/// inserta el objeto con los datos de registro, dentro del arreglo general


    echo json_encode($objetoOrden);
 
/// una vez populado el arreglo general con datos, se convierte a Json

	