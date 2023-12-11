<?php

namespace api\helpers;

class DateHelper
{
    public static function formatDB( $date )
    {
        // 01/12/2023 -> 2023-12-01
        return implode( '-', array_reverse( explode( '/', $date ) ) );
    }
}