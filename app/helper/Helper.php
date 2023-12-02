<?php 

use Illuminate\Support\Facades\Route;

if(!function_exists('set_active')) {
    function set_active($uri, $output = 'active')
{
    if(is_array($uri)){
        foreach($uri as $u){
            if(Route::is($u)){
                return $output;
            }
        }
    }else{
        if(Route::is($uri)){
            return $output;
        }
    }
}
}


if (!function_exists('Rupiah')) {
    function Rupiah($amount)
    {
        $formatter = new NumberFormatter('id_ID', NumberFormatter::CURRENCY);
        $formatter->setTextAttribute(NumberFormatter::CURRENCY_CODE, 'IDR');
        $formatter->setAttribute(NumberFormatter::FRACTION_DIGITS, 0);

        return $formatter->format($amount);
    }
}


?>
