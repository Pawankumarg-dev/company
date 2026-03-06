<?php

namespace App\Http\Controllers\Institute;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Http\Controllers\Controller;

use Session;
use Image;
use App\Configuration;
class FileController extends Controller
{
	public function __construct()
    {
        $this->middleware(['role:institute']);
    }
    public function upload(Request $request){
   		$field = $request->field;
		$file = $request->$field;
		$filename = $request->filename;
	//	$database = \Auth::user()->database_name;
		if(!($file->isValid())){
			return 'failed';
		}else{
			move_uploaded_file($file,"files/temp/".$filename);
			Session::put($field,$filename);
		}
    	return json_encode('success');
    }
	public function uploaddirect(Request $request){
		
		$field = $request->field;
	 $file = $request->$field;
	 $filename = $request->filename;

 //	$database = \Auth::user()->database_name;
	 if(!($file->isValid())){
		 return 'failed';
	 }else{
		$candidate= \App\Candidate::find($request->cid);

		 move_uploaded_file($file,"files/enrolment/photos/".$filename);

//		 Session::put($field,$filename);
	 }
		$candidate->photo = $filename;
		$candidate->save();
	 return json_encode($filename);
 }
	public function crop(Request $request){
		//	$database = \Auth::user()->database_name;
			$data = $request->all();
			$left = intval($data['left']);
			$top = intval($data['top']);
			$height = intval($data['height']);
			$width =  intval($data['width']);
			$filename = $data['filename'];
			$file ="files/temp/".$filename;
			$saveas  = "files/temp/cropped/".$filename;
			/*if(File::exists($saveas)) {
			    File::delete($saveas);
			//	$saveas .= '.1';
			}*/
			$img = Image::make($file);
			$img->crop($width,$height,$left,$top)->save($saveas);
			return 'success';
	}
}
