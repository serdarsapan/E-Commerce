<?php

use Illuminate\Support\Str;

if (!function_exists('generateOTP')) {
    function generateOTP($n){
        $generator = "1357902468";
        $result = '';
        for ($i=1; $i <= $n; $i++) {
            $result = substr($generator,(rand()%(strlen($generator))),11);
        }
        return $result;
    }
}

if (!function_exists('fileDel')) {
    function fileDel($string) {
        if (file_exists($string)) {
            if (!empty($string)) {
                unlink($string);
            }
        }
    }
}

if (!function_exists('imgUpload')) {
    function imgUpload($image,$name,$path) {
        $extension = $image->getClientOriginalExtension();
        $fileName = '-'.Str::slug($name);

        if ($extension == 'pdf' || $extension == 'svg' || $extension == 'webp' ) {

            $image->move(public_path($path),$fileName.'.'.$extension);

            $imageUrl = $path.$fileName.'.'.$extension;
        }else{
            $image = ImageResize::make($image);
            $image->encode('webp', 75)->save($path.$fileName.'.webp');

            $imageUrl = $path.$fileName.'.webp';
        }
        return $imageUrl;

    }
}

if (!function_exists('strLimit')) {
    function strLimit($text, $limit, $url = null) {
        if ($url == null) {
            $end = '...';
        }else{
            $end = '<a class="ml-2" href="'.$url.'">[...]</a>';
        }
        return Str::limit($text, $limit, $end);
    }
}
