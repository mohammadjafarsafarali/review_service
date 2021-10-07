<?php

if (!function_exists('responseApi')) {
    /**
     * @param $status
     * @param $error
     * @param $message
     * @param null $value
     * @return array
     * @author h.kholghi
     */
    function responseApi($status, $error, $message, $value = null): array
    {
        return [
            'status' => $status,
            'error' => $error,
            'message' => $message,
            'value' => $value,
        ];
    }
}
