<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use File;
use Response;
use App\Attachments as Attachs;

class AttachmentsController extends Controller
{
  public function show($id){
    $attach = Attachs::find($id);
    $path = storage_path() . '/' .'app/'. $attach->path;

    if(!File::exists($path)) abort(404);

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
  }
  public function get($id){
    $attach = Attachs::find($id);
    $path = storage_path() . '/' .'app/'. $attach->path;

    if(!File::exists($path)) abort(404);
    return response()->download($path);
  }
}
