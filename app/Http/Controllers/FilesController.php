<?php

namespace App\Http\Controllers;
use App\Http\Controllers\DashboardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Files;
use Illuminate\Support\Facades\Auth;

class FilesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function fileStore(Request $request)
    {
        $file = $request->file('file');

            $fileName = $file->getClientOriginalName();
            $file_privacy = "private";
            $file_type = $file-> getClientOriginalExtension();
           //  $pt = '/camera'; add variable that contain the path of the folder
             $path = Storage::putFileAs('root'.Auth::id().'/',  $file, $fileName);
     
            //$file->move('C:\Users\wonder\Documents\Arduino',$fileName);
          //  $file_filesize = filesize($path);
            $Folder_id = "root".Auth::id();
    
            $fileUpload = new Files();
            $fileUpload->user_id = Auth::id(); 
            $fileUpload->folder_id = 2;
            $fileUpload->filename = $fileName;
            $fileUpload->path =   $path ;
            $fileUpload->privacy = $file_privacy;
            $fileUpload->filesize =  55;
            $fileUpload->folder_id =  $Folder_id;
            $fileUpload->type= $file_type;
            $fileUpload->save();

        return response()->json('success');
    }

    public function Downloadfile($id)
    {
        $fileUpdate = Files::find($id);
        return Storage::download($fileUpdate->path);
    }

   
    public function fileUpdate($id)
    {
        $fileUpdate = Files::find($id);
        $fileName = request('filename');
        $file_privacy = request('privacy');
        $file_description = request('description');
        $file_path = 'root'.Auth::id()."/".$fileName.".".request('extension');
        //move(request('oldpath'),'C:\Users\wonder\Documents\Arduino'.request('oldpath'));
        Storage::move(request('oldpath'), 'root'.Auth::id().'/'.$fileName.".".request('extension'));
        //rename('C:\Users\wonder\Documents\Arduino\1653343445532Screenshot (298).png', 'C:\Users\wonder\Documents\Arduino\Tsafo.png');
        //Storage::move('hodor/oldfile-name.jpg', 'hodor/newfile-name.jpg'); 

        $fileUpdate->filename = $fileName.".".request('extension');
        $fileUpdate->privacy = $file_privacy;
        $fileUpdate->description =   $file_description ;
        $fileUpdate->path = $file_path;
        $fileUpdate->update();
        return response()->json(['success'=>$fileName]);
    }
    public function fileDestroy($id)
    {
        //$FileDelete = Files::find($id);
       Files::where('id',$id)->delete();
        $path = request('path');
        if (file_exists($path)) {
            unlink($path);
        } 
    }
}
