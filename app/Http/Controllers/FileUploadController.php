<?php

namespace App\Http\Controllers;

use App\Helpers\SizeHelper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class FileUploadController extends Controller
{
    private static $directory = 'files';

    public function index()
    {
        $files = Storage::disk('public')->files(FileUploadController::$directory);
        $result = [];
        foreach ($files as $file)
        {
            $result[] = (object)[
                'url' => $file,
                'size' => SizeHelper::bytesToHuman(Storage::disk('public')->size($file)),
                'time' => new Carbon(Storage::disk('public')->lastModified($file)),
            ];
        }

        $collection = collect($result);

        $collection->sortByDesc(function($item){
           return $item->time;
        });

        return view('list', [
            'files' => $collection->values()->all()
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'file' => 'required|mimetypes:text/plain,txt|max:1024',
        ],[
            'mimetypes' => 'Please attach plain text only',
            'max'   => 'Image should be less than 1 MB'
        ]);

        if(!$validator->passes()){
            return response()->json([
                "code" => 420,
                "messages" => $validator->errors()
            ], 420);
        }

        $path = $request->file('file')->store(FileUploadController::$directory , 'public');

        return response()->json([
            "code" => 200,
            "file" => $path
        ]);
    }

    public function destroy($id, Request $request)
    {
        if(Storage::disk('public')->exists(FileUploadController::$directory . '/' . $id))
        {
            Storage::disk('public')->delete(FileUploadController::$directory . '/' . $id);
        }
        return response()->redirectTo('files');
    }
}
