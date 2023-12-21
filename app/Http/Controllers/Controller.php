<?php

namespace App\Http\Controllers;

use App\Models\ImageMedia;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function fileSave($modelName=null, $uploadName, $request, $data)
    {
        $pathOriginal = 'img/' . $uploadName .'/';
        openFile($pathOriginal);

        $image = $request->file('image');
        $imageArr = [];

        $imageUrl = ImageMedia::where('model_name', $modelName)
            ->where('table_id', $data->id)
            ->first();

        if (!empty($imageUrl->data)) {
            foreach ($imageUrl->data as $defaultImg) {
                $defaultImg['showCase'] = 0;
                $imageArr[] = $defaultImg;
            }
        }

        $incomeImage = imageUpload($image, $pathOriginal, $pathOriginal, 850);

        $imageArr[] = [
            'image_no' => time(),
            'image' => $incomeImage['orj'],
            'thumbnail' => $incomeImage['thum'],
            'alt' => '',
            'status' => '1',
            'showCase' => 0
        ];

        $lastIndex = count($imageArr) - 1;
        $imageArr[$lastIndex]['showCase'] = 1;

        ImageMedia::updateOrCreate(
            [
                'table_id' => $data->id,
                'model_name' => $modelName
            ],
            [
                'table_id' => $data->id,
                'model_name' => $modelName,
                'data' =>  json_encode($imageArr)
            ]
        );

    }
}
