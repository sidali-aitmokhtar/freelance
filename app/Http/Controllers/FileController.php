<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileController extends Controller
{
    public function test(Request $request){
        $file = $request->file('ali'); // Changed from 'all' to 'ali'
        $path = $request->file('ali')->storeAs('documents',$file->getClientOriginalExtension());

        if (!$file) {
            return response()->json(['error' => 'No file uploaded']);
        }
        
        return response()->json([
            'file_name' => $file->getClientOriginalName(),
            'file_size' => $file->getSize(),
            'file_mime' => $file->getMimeType(),
            'file_extension' => $file->getClientOriginalExtension(),
            'temp_location' => $file->getPathname(),             // "/tmp/phpABC123" (temp location)
            'pathname' => $file->getRealPath(),             // Same as pathname
            'temp_name' => $file->getFilename()             // "phpABC123" (temp name)
        ]);
    }
}
