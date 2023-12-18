<?php

namespace App\Helpers;

use Hamcrest\Type\IsNumeric;

class ptBRHelper
{
    static function data($my_data)
    {
        if (($my_data == null) or ($my_data == '')) {
            return '';
        }
        if (($my_data == '0000-00-00 00:00:00')) {
            return '';
        }
        if (($my_data == '0000-00-00')) {
            return '';
        }
        if (strlen($my_data) <= 10) {
            return date('d/m/Y', strtotime($my_data));
        }
        return date('d/m/Y H:i:s', strtotime($my_data));
    }
    static function data_sem_hora($my_data)
    {
        if (($my_data == null) or ($my_data == '')) {
            return '';
        }
        if (($my_data == '0000-00-00 00:00:00')) {
            return '';
        }
        if (($my_data == '0000-00-00')) {
            return '';
        }
        if (strlen($my_data) <= 10) {
            return date('d/m/Y', strtotime($my_data));
        }
        return date('d/m/Y', strtotime($my_data));
    }

    static function moeda($my_value = 0)
    {
        if (is_numeric($my_value) == false) {
            return '';
        }
        return number_format($my_value, 2, ',', '.');
    }

    static function real($my_value = 0)
    {
        return 'R$ ' . number_format($my_value, 2, ',', '.');
    }
    static function kwanza($my_value = 0)
    {
        return number_format($my_value, 2, ',', '.') .' Kz';
    }

    static function data_mysql($my_data)
    {
        $data = str_replace("/", "-", $my_data);
        return date('Y-m-d', strtotime($data));
    }

    static function datahora_mysql($my_data)
    {
        $data = str_replace("/", "-", $my_data);
        return date('Y-m-d H:i:s', strtotime($data));
    }

    static function currency_mysql($my_data)
    {
        $ponto = 0;
        if (strpos($my_data, '.') == true) {
            $ponto++;
        }
        if (strpos($my_data, ',') == true) {
            $ponto++;
        }
        if ($ponto == 2) {
            $data = str_replace(".", "", $my_data);
        } else {
            $data = $my_data;
        }
        $data = str_replace(",", ".", $data);
        return doubleVal($data);
    }
    public function formatCurrencyToDatabase($price){
        return str_replace(['.', ','], ['', '.'], $price);
    }
}
