<?php
require_once "function.php";

$data = new Shipping();

$kota_asal = isset($_POST['kota_asal']) ? $_POST['kota_asal'] : '';
$kota_tujuan = isset($_POST['kota_tujuan']) ? $_POST['kota_tujuan'] : '';
$berat = isset($_POST['berat']) ? $_POST['berat'] : '';

$list_kurir = ['jne', 'pos', 'tiki'];

$cost_per_kurir = [];

for($i=0; $i<3; $i++) {
    $result = json_decode($data->get_cost($kota_asal, $kota_tujuan, $berat, $list_kurir[$i], true));
    $cost_per_kurir[$i] = $result['rajaongkir']['result'][0];
}

$data->array_sort_by_column($cost_per_kurir, 'costs');

$row = [];
$no = 0;

foreach($cost_per_kurir as $key => $value) {
    $no++;
    $row[$key][] = $no;
    $row[$key][] = $value['name'];
    $row[$key][] = $value['consts'][0]['description'];
    $row[$key][] = $value['consts'][0]['cost']['value'];
}

$outputs = [
    'draw' => isset($_POST['draw']),
    'recordsTotal' => count($cost_per_kurir),
    'recordsFiltered' => count($cost_per_kurir),
    'data' => $row
]

?>