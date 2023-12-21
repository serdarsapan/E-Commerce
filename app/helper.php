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

if (!function_exists('openFile')) {
    function openFile($filePath, $permissions = 0777) {
        if (!file_exists($filePath)) {
            mkdir($filePath, $permissions, true);
        }
    }
}

if (!function_exists('imgUpload')) {
    function imgUpload($image,$name,$path) {
        $extension = $image->getClientOriginalExtension();
        $fileName = Str::slug($name);

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

if (!function_exists('encrypt')) {
    function encrypt($string) {
        return encrypt($string);
    }
}

if (!function_exists('decrypt')) {
    function decrypt($string)
    {
        return decrypt($string);
    }
}

if (!function_exists('special_path')) {
    function special_path($lang=null,$url=null)
    {
        if (!empty($lang) && $lang != 'en') {
            $langLink = $lang.'.';
        }else {
            $langLink = env('APP_ENV') == 'local' ? '' : 'www.';
        }
        if (!empty($url)) {
            $urlLink = '/'.$url;
        }else {
            $urlLink = '';
        }
        return config('app.app_ssl').$langLink.config('app.url').$urlLink;
    }
}

    if (!function_exists('metaCreate')) {
        function metaCreate($page)

        {
            $pageseo = \App\Models\PageSeo::where('page', $page)->with(['images', 'pages'])->first();

            $metas = [];
            $title = $pageseo->title;
            $description = $pageseo->description;
            $keywords = $pageseo->keywords;
            $currenturl = special_path(app()->getLocale(), $pageseo->page);

            foreach ($pageseo->pages as $pg) {
                $seourl = special_path($pg->lang, $pg->page);
                if ($pg->lang !== app()->getLocale()) {
                    $metas[] = $seourl;
                } else {
                    $title = $pg->title;
                    $description = $pg->description;
                    $keywords = $pg->keywords;
                    $currenturl = $seourl;
                }
            }

            $seoimg = collect($pageseo->images->data ?? '');
            $bgimg = $seoimg->sortByDesc('glassCase')->first()['image'] ?? '';
            $trpage = special_path('tr', $pageseo->page);

            $seoLists = [
                'title' => $title,
                'description' => $description,
                'keywords' => $keywords,
                'currenturl' => $currenturl,
                'metas' => $metas,
                'bgimg' => $bgimg,
                'trpage' => $trpage,
            ];

            return $seoLists;
        }
    }

if (!function_exists('imageUpload')) {
    function imageUpload($image,$path,$pathThumb=NULL,$with=NULL,$height=NULL)
    {

        $fullName = $image->getClientOriginalName();
        $extension = $image->getClientOriginalExtension();
        $onlyName = implode('', explode('.' . $extension, $fullName));
        $filename =  Str::slug($onlyName) . '-' . time(); //generateOTP(6).'-'.time();

        if ($image->extension() == 'svg' || $image->extension() == 'webp' || $image->extension() == 'pdf' || $image->extension() == 'ico') {
            $orjiUrl = $path . $filename . '.' . $image->extension();


            \Illuminate\Support\Facades\Storage::disk('public')->putFileAs('',$image->path(), $orjiUrl);

            $imagear['orj'] = $orjiUrl;

            if(!empty($paththumb)) {
                $thumbUrl = $orjiUrl;
                $imagear['thum'] = $thumbUrl;
            }else {
                $imagear['thum'] = NULL;
            }

        } else {
            $orjiUrl = $path . $filename . '.webp';
            \Illuminate\Support\Facades\Storage::disk('public')->put($orjiUrl, \ImageResize::make($image->path())->encode('webp', 90));

            $imagear['orj'] = $orjiUrl;

            if(!empty($pathThumb)) {

                $thumbUrl = $pathThumb . 'thumb_' . $filename . '.webp';
                \Illuminate\Support\Facades\Storage::disk('public')->put($thumbUrl, \ImageResize::make($image->path())
                    ->resize($with, $height, function ($constraint) {$constraint->aspectRatio();})
                    ->encode('webp', 90));

                $imagear['thum'] = $thumbUrl;
            }else {
                $imagear['thum'] = NULL;
            }


        }

        return  $imagear;
    }
}



