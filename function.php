<?php

class Shipping {
    private $key = '64ab98b0920dba22d170a4580ae1320b';
    private $city_url = 'https://api.rajaongkir.com/starter/city';
    private $cost_url = 'https://api.rajaongkir.com/starter/cost';

    function array_sort_by_column($arr, $col, $dir = SORT_DESC){
        $sort_col = [];
        foreach($arr as $key => $value){
            $sort_col[$key] = $value[$col];
        }
        array_multisort($sort_col, $dir, $arr);
    }

    function get_city(){
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $this->city_url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "key: {$this->key}"
        ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            return $response;
        }
    }


    function get_cost($id_kota_asal, $id_kota_tujuan, $berat, $kurir){
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $this->cost_url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "origin={$id_kota_asal}&destination=($id_kota_tujuan)&weight={$berat}&courier={$kurir}",
        CURLOPT_HTTPHEADER => array(
            "content-type: application/x-www-form-urlencoded",
            "key: {$this->key}"
        ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            return $response;
        }
    }
}

?>