<?php


function format_rupiah($value, $condition = null)
{
    if ($condition == true) {
        return ($value == 0) ? '' : 'Rp ' . number_format($value, 0, ',', '.');
    } else {
        return number_format($value, 0, ',', '.');
    }
}
