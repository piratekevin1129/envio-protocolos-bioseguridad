<?php 
$ciudades_url = "municipios.json";
$ciudades_file = file_get_contents($ciudades_url);
$ciudades_data = json_decode($ciudades_file,true);

$html = '<table border="1">';
for($i = 0;$i<count($ciudades_data);$i++){
	$dpto = $ciudades_data[$i];
	$dpto_name = $dpto['departamento'];
	$municipios = $dpto['municipios'];
	$html.='<tr>';
	$html.='<td>'.$dpto_name.'</td>';
	$html.='<td><table border="1">';
	for($j = 0;$j<count($municipios);$j++){
		$html.='<tr><td>'.$municipios[$j]['municipio'].'</td></tr>';
	}
	$html.='</table></td>';
	$html.='</tr>';
}
$html.='</table>';

$file="municipios.xls";

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=$file");
echo $html;

?>