<?php

class Sort {

    /**
     * @param array $array
     * @return array
     */
    public function bubbleSort(array $array) : array
    {
        $count = count($array);
        if ($count <= 1) return $array;
        for ($i = 0; $i < $count; $i++) {
            $break = true;
            for ($j = 0; $j < $count-$i-1; $j++) {
                print_r($array[$j].':'.$array[$j+1].',');
                if ($array[$j] > $array[$j+1]) {
                    $array[$j]   = $array[$j] ^ $array[$j+1];
                    $array[$j+1] = $array[$j] ^ $array[$j+1];
                    $array[$j]   = $array[$j] ^ $array[$j+1];
                    $break = false;
                }
            }
            print_r("\r\n");
            // 如果本次循环未发生交换，则认为该数组已有序
            if ($break) break;
        }
        return $array;
    }

    /**
     * @param array $array
     * @return array
     */
    public function insertSort(array $array) : array
    {
        $count = count($array);
        if ($count <= 1) return $array;
        for ($i = 0; $i < $count; $i++) {
            $value = $array[$i];
            $j = $i-1;
            for (; $j >= 0; $j--) {
                if ($array[$j] > $value) {
                    $array[$j+1] = $array[$j];
                } else {
                    break;
                }
            }
            $array[$j+1] = $value;
        }
        return $array;
    }

    /**
     * @param array $array
     * @return array
     */
    public function selectionSort(array $array) : array
    {
        $count = count($array);
        if ($count <= 1) return $array;
        for ($i = 0; $i < $count; $i++) {
            $max = $i;
            for ($j = $i + 1; $j < $count; $j++) {
                if ($array[$max] < $array[$j]) {
                    $max = $j;
                }
            }
            if ($max != $i) {
                $array[$max] ^= $array[$i];
                $array[$i] ^= $array[$max];
                $array[$max] ^= $array[$i];
            }
        }
        return $array;
    }

    /**
     * @param array $array
     * @return array
     */
    public function mergeSort(array $array) : array
    {
        $count = count($array);
        if ($count <= 1) return $array;
        $this->doMerge($array, 0, $count-1);
        return $array;
    }

    private function doMerge(&$array, int $start, int $end)
    {
        if ($start >= $end) return;
        $middle = floor(($start + $end) / 2);
        $this->doMerge($array, $start, $middle);
        $this->doMerge($array, $middle + 1, $end);
        $this->doMergeSort($array, ['start' => $start, 'end' => $middle], ['start' => $middle + 1, 'end' => $end]);
    }

    private function doMergeSort(array &$array, array $prev, array $next)
    {
        $i = $prev['start'];
        $j = $next['start'];
        $temp = [];
        print_r($prev);print_r($next);
        while ($i <= $prev['end'] && $j <= $next['end']) {
            if ($array[$i] > $array[$j]) {
                $temp[] = $array[$i++];
            } else {
                $temp[] = $array[$j++];
            }
        }

        if ($i <= $prev['end']) {
            for (; $i <= $prev['end']; $i++) {
                $temp[] = $array[$i];
            }
        }

        if ($j <= $next['end']) {
            for (; $j <= $next['end']; $j++) {
                $temp[] = $array[$j];
            }
        }

        print_r($temp);

        for ($i = $prev['start']; $i <= $next['end']; $i++) {
            $array[$i] = array_shift($temp);
        }
    }

    /**
     * @param array $array
     * @return array
     */
    public function quickSort(array $array) : array
    {
        $count = count($array);
        if ($count <= 1) return $array;
        $this->doQuickGroup($array, 0, $count-1);
        return $array;
    }

    private function doQuickGroup(array &$array, int $start, int $end)
    {
        if ($start >= $end) return;

        $index = $this->doQuickSort($array, $start, $end);
        $this->doQuickGroup($array, $start, $index-1);
        $this->doQuickGroup($array, $index+1, $end);
    }

    private function doQuickSort(array &$array, int $start, int $end) : int
    {
        $pivot = $array[$end];
        $i = $start;

        for ($j = $start; $j < $end; $j++) {
            if ($array[$j] < $pivot) {
                $temp = $array[$j];
                $array[$j] = $array[$i];
                $array[$i] = $temp;
                $i++;
            }
        }

        $temp = $pivot;
        $array[$end] = $array[$i];
        $array[$i] = $temp;

        return $i;
    }

}

/**********************************************************************************************************************/

$array = [4, 5, 7, 6, 8, 3, 0, 2, 9, 1];
$client = new Sort();
$result = $client->quickSort($array);
print_r($result);
