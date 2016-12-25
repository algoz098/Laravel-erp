<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use File;
use Response;
use Intervention\Image\ImageManagerStatic as Image;
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

  public function delete($id){
    $attach = Attachs::withTrashed()->find($id);

    if ($attach->trashed()) {
      $attach->restore();
    } else {
       $attach->delete();
    }

    return redirect()->back();
  }

  public function rotate_clock($id){
    $attach = Attachs::find($id);
    $path = storage_path() . '/' .'app/'. $attach->path;

    if(!File::exists($path)) abort(404);
    $file = Image::make($path)->rotate(270);

    $file->save();
  }
  public function rotate_unclock($id){
    $attach = Attachs::find($id);
    $path = storage_path() . '/' .'app/'. $attach->path;

    if(!File::exists($path)) abort(404);
    $file = Image::make($path)->rotate(90);

    $file->save();
    return $file->response('jpg');
  }

  public function resize($id, $width){
    $attach = Attachs::find($id);
    $path = storage_path() . '/' .'app/'. $attach->path;

    if(!File::exists($path)) abort(404);
    $file = Image::make($path)->resize($width, null, function ($constraint) {
        $constraint->aspectRatio();
        $constraint->upsize();
    });

    $file->save();
    return $file->response('jpg');
  }

  public function size($id, $height){
    $attach = Attachs::find($id);
    $path = storage_path() . '/' .'app/'. $attach->path;

    if(!File::exists($path)) abort(404);
    $file = Image::make($path)->resize(null, $height, function ($constraint) {
        $constraint->aspectRatio();
        $constraint->upsize();
    });

    return $file->response('jpg');
  }
}
