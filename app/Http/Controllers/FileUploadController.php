<?php

namespace App\Http\Controllers;

use App\Helpers\SizeHelper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

        return view('list', [
            'files' => $result
        ]);
    }

    public function store(Request $request)
    {
        $path = $request->file('file')->store(FileUploadController::$directory , 'public');
        $result = [
            'link' => $path
        ];
        return response()->json($result);
    }
}
