<?php

namespace App\Http\Controllers\TTK;

use App\Models\Ttk;

class ImageController extends BaseController
{
    public function __invoke($ttkImageID)
    {
        $id=explode(".", $ttkImageID);
        $rendered_buffer= TTK::all()->find($id[0])->image;

        $response = ttk::make($rendered_buffer);
        $response->header('Content-Type', 'image/png');
        $response->header('Cache-Control','max-age=2592000');
        return $response;
    }
}
