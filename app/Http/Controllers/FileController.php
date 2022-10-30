<?php

namespace App\Http\Controllers;

use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{

    use HttpResponses;

    /**
     * general function for uploading file
     *
     * @return \Illuminate\Http\Response
     */
    public function uploadFile(Request $request)
    {
        $file = $request->hasFile('file');

        if($file){
            $newFile = $request->file('file');
            Storage::put($newFile->getClientOriginalName(), $newFile);
            $response =  Storage::url($newFile->getClientOriginalName());

            return $this->success([
                'url' => $response,
            ], 'Successfully uploaded the file');
            
        }
    }
}
