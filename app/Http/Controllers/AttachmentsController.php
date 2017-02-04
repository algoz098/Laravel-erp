<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use File;
use Response;
use Intervention\Image\ImageManagerStatic as Image;
use App\Attachments as Attachs;
use Carbon\Carbon;
use Log;
use Auth;

class AttachmentsController  extends BaseController
{
  public function __construct(){
     parent::__construct();
  }
  
  public function show($id){
    $attach = Attachs::find($id);
    $path = storage_path() . '/' .'app/'. $attach->path;

    if(!File::exists($path)) abort(404);

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    Log::info('Vendo anexo, anexo -> "'.$attach.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    return $response;
  }
  public function get($id){
    $attach = Attachs::find($id);
    $path = storage_path() . '/' .'app/'. $attach->path;

    Log::info('Download de anexo -> "'.$attach.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());

    if(!File::exists($path)) abort(404);
    return response()->download($path);
  }

  public function delete($id){
    $attach = Attachs::withTrashed()->find($id);

    if ($attach->trashed()) {
      Log::info('Restaurando anexo -> "'.$attach.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
      $attach->restore();
    } else {
      Log::info('Deletando anexo -> "'.$attach.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
      $attach->delete();
    }

    return redirect()->back();
  }

  public function rotate_clock($id){
    $attach = Attachs::find($id);
    $path = storage_path() . '/' .'app/'. $attach->path;

    if(!File::exists($path)) abort(404);
    $file = Image::make($path)->rotate(270);
    Log::info('Virando anexo sentido relogio -> "'.$attach.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());

    $file->save();
  }
  public function rotate_unclock($id){
    $attach = Attachs::find($id);
    $path = storage_path() . '/' .'app/'. $attach->path;

    if(!File::exists($path)) abort(404);
    $file = Image::make($path)->rotate(90);
    Log::info('Virando anexo sentido anti relogio -> "'.$attach.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
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
    Log::info('Redimensionando anexo para ->"'.$width.'" de largura -> "'.$attach.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
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
    Log::info('Mostrando anexo tamanho da tela -> "'.$attach.'", para -> ID:'.Auth::user()->contato->id.' nome:'.Auth::user()->contato->nome.' Usuario ID:'.Auth::user()->id.' ip:'.request()->ip());
    return $file->response('jpg');
  }
}
