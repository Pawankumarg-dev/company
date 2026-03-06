<?php

namespace App\Http\Controllers\Institute;

use Illuminate\Http\Request;
use Validator;
use App\Http\Requests;

use App\Approvedprogramme;
use App\Http\Controllers\Controller;
use App\Programmeapprovalfile;
use Session;
use Auth;
use PDF;


class ApprovedprogrammeController extends Controller
{
	public function __construct()
    {
        $this->middleware(['role:institute']);
    }
	
    public function store(Request $request){
    	$this->validate($request, [
        'filename' => 'required',
        'maxintake' => 'required|numeric|min:1|max:100',
        'programme_id' => 'required|numeric|min:1'
   		 ]);
		
    	$ap = Approvedprogramme::create(['institute_id'=>$request->institute_id,'programme_id'=>$request->programme_id,'academicyear_id'=>$request->academicyear_id,'status_id'=>$request->status_id,'maxintake'=>$request->maxintake]);
		$file = "";
		$count = 1;
		foreach ($request->file('filename') as $f){
			$file = $f;
			if($file){
			$filename = $request->user_id . '_' . $request->programme_id . "._". $count . "." . $file->getClientOriginalExtension();
			$file->move('files/rciapproval/',$filename);
			$ap->programmeapprovalfiles()->create(['filename'=>$filename,'approvedprogramme_id'=>$ap->id]); 
			$count += 1;
			}
		}
		return redirect('programmeslist');

    }
	
	public function update($id,Request $request){
    	$this->validate($request, [
        'maxintake' => 'required|numeric|min:1|max:100',
   		 ]);
    	$ap = Approvedprogramme::find($id);
		if($ap->institute->user_id==Auth::user()->id){
	    	$ap->update(['maxintake'=>$request->maxintake]);
			$file = "";
			$count = $ap->programmeapprovalfiles()->count() + 1;
			foreach ($request->file('filename') as $f){
				$file = $f;
				if($file){
				$filename = $request->user_id . '_' . $request->programme_id . "._". $count . "." . $file->getClientOriginalExtension();
				$file->move('files/rciapproval/',$filename);
				$ap->programmeapprovalfiles()->create(['filename'=>$filename,'approvedprogramme_id'=>$ap->id]); 
				$count += 1;
				}
			}
		}
			 /*
		if($request->file('filename')){
			$file = $request->file('filename');
			$filename = $request->user_id . '_' . $request->programme_id . "." . $file->getClientOriginalExtension();
			$file->move('files/rciapproval/',$filename);
			$ap->update(['filename'=>$filename]);
		}*/
		return redirect('programmeslist');
    }
	public function destroy($id){
		$ap = Approvedprogramme::find($id);
		if($ap->institute->user_id==Auth::user()->id){
			$apc= $ap->candidates()->count();
			if($apc==0){
				Approvedprogramme::destroy($id);
				Session::put('messages','Deleted');
			}else{
				Session::put('error','Cannot be deleted as there is enrolments');
			}
		}
		return redirect('programmes');
	}
	public function deletefile($id){
		$f = Programmeapprovalfile::find($id);
		$ap = Approvedprogramme::find($f->approvedprogramme_id);
		if($ap->programmeapprovalfiles()->count() > 1){
			$f->delete();
		}else{
			Session::put('error','Minimum one letter required.');
		}
		return back();
	}
	
	public function pdf($id){
		
		$ap = Approvedprogramme::find($id);
		if($ap->institute->user_id==Auth::user()->id){
			$html = "<img src='".public_path()."/images/header.png' style='width:100%!important' /><br />";
			$html .= "<style>.table  tr  td{vertical-align:top; border-bottom:1px solid #AAAAAA;padding:10px!important;margin:0!important;}</style>";
			$html .= "<table style='width:100%'><tr><td>Center Code</td><td>";
			$html  .=  $ap->institute->user->username;
			$html .= '</td></tr><tr><td>Center Name</td><td>';
			$html .= $ap->institute->name;
			$html .= '</td></tr><tr><td>Programme Code</td><td>';
			$html  .= $ap->programme->course_name;
			$html .= '</td></tr><tr><td>Programme </td><td>';
			$html .= $ap->programme->name;
            //$html .= '</td></tr><tr><td>Batch </td><td>2017</td></tr><tr><td>Max Intake</td><td>';
            $html .= '</td></tr><tr><td>Batch</td><td>'.$ap->academicyear->year.'</td></tr><tr><td>Max Intake</td><td>';
            $html .= $ap->maxintake;
			$html .= '</td></tr><tr><td>Applied </td><td>';
			$html .= $ap->candidates->count();
			$html .= "</td></tr></table>";
			
			$html .='<hr /><table style="width:100%;" class="table"><tr><td>Sl No</td><td>Enrolment #</td><td>Name</td><td>DOB</td><td>Gender</td><td>Photo</td></tr>';
			$i = 1;
			foreach($ap->candidates as $c){
				$html .= '<tr><td>'. $i ;
				$i +=1;
                //$html .= '</td><td>TBA</td><td>';
                $html .= '</td><td>'.$c->enrolmentno.'</td><td>';
				$html .= $c->name;
				$html .= "</td><td>";
				//$html .= $c->dob->format('mm-dd-YYYY');
				
				$date = \Carbon\Carbon::parse($c->dob);
				
				$html .=  $date->toFormattedDateString();
				$html .= "</td><td>";
				$html .= $c->gender->gender ;
				$html .= "</td><td>";
				$html .= "<img src='".public_path()."/files/enrolment/photos/".$c->photo."' style='height:80px!important' />";			
				$html .= "</td></tr>";
			}
			$html .= '</table>';
			$pdf = PDF::setOptions(['isRemoteEnabled' => true])->loadHtml($html);
		    //$html .= public_path()."";
			//$pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadView('institute.pdf.candidate',compact('ap'));
			//return $pdf->stream();
			return $pdf->download($ap->institute->user->username.'_candidates_'.$ap->programme->course_name.'.pdf');
		}
	}
	
}
