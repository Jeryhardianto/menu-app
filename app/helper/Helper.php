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


if (!function_exists('image_url')) {
    /**
     * URL gambar yang aman: kalau file uploadnya hilang, jatuh ke gambar bawaan
     * supaya tidak muncul icon broken image.
     */
    function image_url($path, $default = 'image/user-default.jpg')
    {
        if (blank($path)) {
            return asset($default);
        }

        if (str_starts_with($path, 'http')) {
            return $path;
        }

        // gambar bawaan di public/, hasil upload di storage/app/public (via symlink public/storage)
        foreach ([$path, 'storage/' . $path] as $candidate) {
            if (is_file(public_path($candidate))) {
                return asset($candidate);
            }
        }

        return asset($default);
    }
}


?>
