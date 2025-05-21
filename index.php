<?php

/**
 * Cari produk pasangan elemen berdekatan terbesar di dalam array.
 *
 * @param int[] $arr
 * @return int
 * @throws Exception jika array terlalu pendek
 */
function maxAdjacentProduct(array $arr): int
{
    $n = count($arr);
    if ($n < 2) {
        throw new Exception('Array harus berisi minimal 2 elemen');
    }

    $maxProd = $arr[0] * $arr[1];
    for ($i = 1; $i < $n - 1; $i++) {
        $prod = $arr[$i] * $arr[$i + 1];
        if ($prod > $maxProd) {
            $maxProd = $prod;
        }
    }

    return $maxProd;
}

// Contoh:
echo maxAdjacentProduct([3, 6, -2, -5, 7, 3]) . "\n"; // 21
echo maxAdjacentProduct([5, 1, 2, 3, 1, 4]) . "\n";  // 6
echo maxAdjacentProduct([-1, -2]) . "\n";        // 2