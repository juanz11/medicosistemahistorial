<?php
if (!function_exists('id_valido')) {
    function id_valido($id)
    {
        return $id != null && $id > 0;
    }
}