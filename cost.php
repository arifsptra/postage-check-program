<?php
require_once "function.php";

$data = new Shipping();

$kota_asal    = isset($_POST['kota_asal']) ? $_POST['kota_asal'] : ''; // kota asal
$kota_tujuan  = isset($_POST['kota_tujuan']) ? $_POST['kota_tujuan'] : ''; // kota tujuan
$berat        = isset($_POST['berat']) ? $_POST['berat'] : ''; // berat
  
$list_courir = ['jne', 'pos', 'tiki']; // Untuk tipe akun starter ada 3 pilhan kurir
  
$cost_per_courir = [];
  
// Perulangan untuk memanggil fungsi get_cost berdasarkan list kurir
for ($i = 0; $i < 3; $i++) :
  $result = json_decode($data->get_cost($kota_asal, $kota_tujuan, $berat, $list_courir[$i]), true);
  $cost_per_courir[] = $result['rajaongkir']['results'][0];
endfor;
  
$data->array_sort_by_column($cost_per_courir, 'costs'); // Sort berdasarkan costs
$row  = [];
$no = 0;
  
foreach ($cost_per_courir as $key => $value) :
  $no++;
  $row[$key][]  = $no;
  $row[$key][]  = $value['name'];
  $row[$key][]  = $value['costs'][0]['description'];
  $row[$key][]  = 'Rp.' . number_format($value['costs'][0]['cost'][0]['value']);
endforeach;
  
// Tampilkan ke datatables
$output = [
  "draw"              => isset($_POST['draw']),
  "recordsTotal"      => count($cost_per_courir),
  "recordsFiltered"   => count($cost_per_courir),
  "data"              => $row,
];
  
echo json_encode($output);
?>