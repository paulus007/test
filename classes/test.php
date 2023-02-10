<?php

    namespace Pavelp\Test;

    class Weather {

        // Массив с полученными данными
        private $data = [];
        // Массив с обработанными данными
        public  $sma  = [];

        public function __construct(){
            return true;
        }

        // Метод разбирает файл с исходными данными
        // на вход принимает путь к файлу
        public function parseFile($path = null) {
            if ($path) {
                try {
                    $res   = [];
                    $tmp_a = [];
                    $day   = "";
                    if ($handle = fopen($path, "r")) {
                        while ($row = fgetcsv($handle, null, ";")) {
                            if ($timestamp = strtotime($row[0])) {
                                if ($day && ($day !== date("Y-m-d", $timestamp) && count($tmp))) {
                                    $res[$day] = round(array_sum($tmp) / count($tmp), 1);
                                    $tmp = [];
                                }
                                $tmp[] = $row[1];
                                $day = date("Y-m-d", $timestamp);
                            }
                        }
                        if ($day && count($tmp)) {
                            $res[$day] = round(array_sum($tmp) / count($tmp), 1);
                        }
                        $this->data = $res;
                        return true;
                    }
                    return false;
                }
                catch (Exception $e) {
                    return false;
                }
            }
            return false;
        }

        // Метод вычисляет среднее скользящее с заданой шириной окна
        // на вход принимает ширину окна ('day' | 'week' | 'month')
        public function calcSMA($window = "day") {
            $data = &$this->data;
            if (count($data)) {
                ksort($data);
                switch ($window) {
                    case "day"  :
                        $window_size = 3;
                        break;
                    case "week" :
                        $window_size = 7;
                        break;
                    case "month":
                        $window_size = 30;
                        break;
                    default:
                        return false;
                }
                $i = 1;
                $res = [];
                foreach ($data as $date => $avg_t) {
                    $tmp = array_slice(
                        $data,
                        ($window_size > $i ? 0  : $i - $window_size),
                        ($window_size > $i ? $i : $window_size)
                    );
                    $res[] = (object) [
                        'date' => $date,
                        'real' => $avg_t,
                        'sma'  => round(array_sum($tmp) / count($tmp), 1),
                    ];
                    $i++;
                }
                $this->sma = $res;
                return true;
            }
            return false;
        }
    }

?>
