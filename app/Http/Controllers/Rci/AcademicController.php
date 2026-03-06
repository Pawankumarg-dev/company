<?php

namespace App\Http\Controllers\Rci;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Http\Requests;

use App\Institute;
use App\User;
use Session;
use App\Masterlist;
use App\Academicyear;
use App\Configuration;
use App\Programme;
use App\Approvedprogramme;

class AcademicController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:rci']);
    }
	
	 public function index(Request $r){
        $academicyearname= Session::get('academicyear');
        $academicyear_id= Session::get('academicyear_id');
        $currentacademicyear = Academicyear::where('current',1)->first();
        if($r->has('search')){
            $collections = Institute::where('code','like','%'.$r->search.'%')->orWhere('rci_code','like','%'.$r->search.'%');
            if(strlen($r->search) > 3){
                $collections = $collections->orWhere('name','like','%'.$r->search.'%')->orWhere('street_address','like','%'.$r->search.'%');
            }
            $collections  =  $collections->orderBy('code')->paginate(100);
        }else{
            $collections = Institute::where('active_status', '1')->orderBy('code')->paginate(100);
        }
        $link = 'academics';
        $text = 'Admissions (Academic Year -'. $academicyearname .')';
        $enrolment = Configuration::where('attribute','enrolment')->first()->value;
        $programmes = Programme::where('active_status',1)->orderBy('abbreviation')->get();
        return view('rci.academic.admissions.index', compact('programmes','collections','link','text','currentacademicyear','academicyear_id','enrolment'));
    }
	public function show($id){
    	$institute = Institute::find($id);
        
    	return view('rci.institutes.show',compact('institute'));
    }
    public function update(Request $request){
        $rules = [
            'maxintake' => 'required|numeric|min:1',
        ];
        $messages = [
            'maxintake.required' => 'Password is required',
        ];
        $approvedprogramme = Approvedprogramme::find($request->id);
        
        $approvedprogramme->programme_id = $request->programme_id;
        $approvedprogramme->maxintake = $request->maxintake;
        $enable_admission = $request->has('enable_admission') ? 1 : 0;
        if($request->has('enable_admission')){
            $approvedprogramme->enable_admission_till =$request->enable_admission_till;
        }else{
            $approvedprogramme->enable_admission_till = null;
        }
        $approvedprogramme->enable_admission =$enable_admission;
        $approvedprogramme->save();
        return back();
    }
    public function delete(Request $r){
        $approvedprogramme = Approvedprogramme::where('id',$r->id)->withTrashed()->first();
        if(is_null($approvedprogramme->deleted_at)){
            $approvedprogramme->delete();
            return response()->json('Deleted');
        }else{
            $approvedprogramme->restore();
            return response()->json('Restored');
        }
    }
    public function create(Request $request){
        $this->validate($request, [
                'maxintake' => 'required|numeric|min:1|max:100',
                'programme_id' => 'required|numeric|min:1'
            ]);
            $enable_admission = $request->has('enable_admission') ? 1 : 0;
            $enable_admission_till = $request->has('enable_admission') ? $request->enable_admission_till : null;
            $ap = Approvedprogramme::create(['institute_id'=>$request->institute_id,'programme_id'=>$request->programme_id,'academicyear_id'=>Session::get('academicyear_id'),'status_id'=>1,'maxintake'=>$request->maxintake,'enable_admission'=>$enable_admission,'enable_admission_till'=>$enable_admission_till]);
            Session::put('message','Updated!');
            return back();
    }

    public function showInstituteLists() {
    }

    public function showCentreInformation($id) {
        $institute = Institute::find($id);
        $states = State::orderBy('state_name')->get();
        $cities = City::orderBy('name')->get();

        return view('nber.institutes.centreinformation.showCentreInformation', compact('institute', 'states', 'cities'));
    }

    public function updateCentreInformation(Request $request) {
        $institute = Institute::find($request->institute_id);

        $institute->update([
            'street_address' => $request->street_address,
            'postoffice' => $request->postoffice,
            'landmark' => $request->landmark,
            'city_id' => $request->city_id,
            'pincode' => $request->pincode,
            'contactnumber1' => $request->contactnumber1,
            'contactnumber2' => $request->contactnumber2,
            'email' => $request->email,
            'email2' => $request->email2,
            'website' => $request->website,
            'faxno' => $request->faxno
        ]);

        $institute->institutehead->update([
            'name' => $request->head_name,
            'designation' => $request->head_designation,
            'qualification' => $request->head_qualification,
            'email' => $request->head_email,
            'rci_reg_no' => $request->head_rci_reg_no,
            'contactnumber1' => $request->head_contactnumber1,
            'contactnumber2' => $request->head_contactnumber2,
        ]);

    }

    public function showInstituteInformationUpdateNotifications() {
        //$institutes = Institute::where('active_status', '1')->orderBy('code')->get();
        //return view('nber.institutes.showNotifications', compact('institutes'));
        $states = State::orderBy('state_name')->get();
        $cities = City::orderBy('name')->get();
        $institutes = Institute::where('active_status', '1')->orderBy('code')->get();
        return view('nber.institutes.sample', compact('institutes', 'states', 'cities'));
    }

    public function showInstituteInformation($institute_id) {

    }

    public function loadData() {
        $information = Instituteinformationupdate::where('active_status', '1')->first();

        $data = [];

        foreach ($information as $i) {
            $data[] = [
                'id' => $i->institute->id,
                'code' => $i->institute->code,
                'name' => $i->institute->name,
                'remarks' => $i->update_remarks,
                'date' => $i->created_at->format('d-m-Y h:i:s A'),
            ];
        }

        return response()->json($data);
    }

    public function getInstituteInformation(Request $request) {
        $institute = Institute::where('id', $request->id)->first();

        $instituteinformationupdate = Instituteinformationupdate::where('id', $institute->id)->first();
        $institutehead = Institutehead::where('institute_id', $institute->id)->first();
        $institutefacility = Institutefacility::where('institute_id', $institute->id)->first();
        $institutecertificateincharge = Institutecertificateincharge::where('institute_id', $institute->id)->first();


        $data[] = [
            'id' => $institute->id,
            'code' => $institute->code,
            'name' => $institute->name,
            'address' => function($institute) {
                return $institute->street_address.' '.$institute->postoffice.' Post Office'.$institute->city->name.' Dist., '.$institute->city->state->state_name.' - '.$institute->pincode;
            },
            'update_remarks' => $instituteinformationupdate->update_remarks,
        ];

        return response()->json($data);
    }

    public function updateStatus(Request $request) {

    }

    public function showInstitutes() {
        $institutes = Institute::where('active_status', 1)->orderBy('code')->get();

        return view('nber.institutes.show_institutes',compact('institutes'));
    }

    public function printInstituteAddress($id) {
        $institute = Institute::find($id);

        $title = $institute->code.' - Print Address';

        $yearSpecification = (date('m') >= 4 ? date('Y').'-'.(date('y')+1) : (date('Y')-1).'-'.date('y'));

        return view('nber.institutes.print_institute_address',compact('institute', 'title', 'yearSpecification'));
    }

    public function downloadInstitutesAddress() {
        $institutes = Institute::where('active_status', 1)->orderBy('code')->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $styleArray = [
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
            ]
        ];

        $sheet->setCellValue('A1', 'S.No');
        $sheet->setCellValue('B1', 'Inst. Code');
        $sheet->setCellValue('C1', 'Inst. Name');
        $sheet->setCellValue('D1', 'Contact Details');
        $sheet->setCellValue('E1', 'District');
        $sheet->setCellValue('F1', 'State');
        $sheet->setCellValue('G1', 'Pincode');
        $sheet->setCellValue('H1', 'Email.#1');
        $sheet->setCellValue('I1', 'Email.#2');
        //$sheet->setCellValue('J1', 'ContactNo.#1');
        //$sheet->setCellValue('K1', 'ContactNo.#2');

        //setting Text Wrap for Columns
        $sheet->getStyle('A1:K1')->getAlignment()->setWrapText(true);

        //Setting Column Width
        $sheet->getColumnDimension('A')->setWidth(5, 'pt');
        $sheet->getColumnDimension('B')->setWidth(7, 'pt');
        $sheet->getColumnDimension('C')->setWidth(20, 'pt');
        $sheet->getColumnDimension('D')->setWidth(45, 'pt');
        $sheet->getColumnDimension('E')->setWidth(14, 'pt');
        $sheet->getColumnDimension('F')->setWidth(14, 'pt');

        //Applying styles
        $sheet->getStyle('A1:I1')->applyFromArray($styleArray);
        $sheet->getStyle('A1:I1')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('A1:I1')->getFont()->setBold(true);

        $sheet->getStyle('A1:I1')->getFont()->setName('Bookman Old Style');
        $sheet->getStyle('A1:I1')->getFont()->setSize(8);

        $rowCount = 2;
        $sno = 1;
        foreach ($institutes as $institute) {
            $address = $institute->name." (".$institute->code.")\n";

            if($institute->street_address != '')
                $address .= $institute->street_address."\n";

            if(!is_null($institute->postoffice))
                $address .= $institute->postoffice."POST OFFICE \n";

            $district = "";
            $state = "";
            if($institute->city_id != 0) {
                $district = $institute->city->name;
                $state = $institute->city->state->state_name;

                $address .= $district." DIST., \n".$state;
            }

            if($institute->pincode != '')
                $address .= '-'.$institute->pincode;

            if($institute->landmark != '')
                $address .= "\nLandmark: ".$institute->landmark;

            if($institute->email != '')
                $address .= "\nEmail(s): ".$institute->email;

            if($institute->email2 != '')
                $address .= ', '.$institute->email2;


            if($institute->contactnumber1 != '')
                $address .= "\nContact No(s): ".$institute->contactnumber1;

            if($institute->contactnumber2 != '')
                $address .= ', '.$institute->contactnumber2;

            $sheet->setCellValue('A'.$rowCount, $sno);
            $sheet->setCellValue('B'.$rowCount, $institute->code);
            $sheet->setCellValue('C'.$rowCount, $institute->name);
            $sheet->setCellValue('D'.$rowCount, $address);
            $sheet->setCellValue('E'.$rowCount, $district);
            $sheet->setCellValue('F'.$rowCount, $state);
            $sheet->setCellValue('G'.$rowCount, $institute->pincode);
            $sheet->setCellValue('H'.$rowCount, $institute->email);
            $sheet->setCellValue('I'.$rowCount, $institute->email2);

            //$sheet->setCellValue('J'.$rowCount, $institute->contactnumber1);
            //$sheet->setCellValue('K'.$rowCount, $institute->contactnumber2);

            //Setting Text Wrap for Cells
            $sheet->getStyle('C'.$rowCount)->getAlignment()->setWrapText(true);
            $sheet->getStyle('D'.$rowCount)->getAlignment()->setWrapText(true);
            $sheet->getStyle('E'.$rowCount)->getAlignment()->setWrapText(true);
            $sheet->getStyle('F'.$rowCount)->getAlignment()->setWrapText(true);
            $sheet->getStyle('H'.$rowCount)->getAlignment()->setWrapText(true);
            $sheet->getStyle('I'.$rowCount)->getAlignment()->setWrapText(true);
            //$sheet->getStyle('J'.$rowCount)->getAlignment()->setWrapText(true);
            //$sheet->getStyle('K'.$rowCount)->getAlignment()->setWrapText(true);

            //Applying Styles
            $sheet->getStyle('A'.$rowCount.':I'.$rowCount)->applyFromArray($styleArray);
            $sheet->getStyle('A'.$rowCount.':I'.$rowCount)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

            $sheet->getStyle('A'.$rowCount.':I'.$rowCount)->getFont()->setName('Bookman Old Style');
            $sheet->getStyle('A'.$rowCount.':I'.$rowCount)->getFont()->setSize(8);

            $rowCount++;
            $sno++;

            unset($address);
            unset($institute);
        }

        $sheet->getPageMargins()->setLeft(0.5);

        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
        $sheet->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 1);

        $sheet->getHeaderFooter()->setOddHeader('&C&H&B&"Bookman Old Style-" Details of Institute Address');
        $sheet->getHeaderFooter()->setOddFooter('&C&H&B&"Bookman Old Style-" Page &P of &N');

        $filename = 'Institutes Address Details.xlsx';
        ob_end_clean();
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');

        $writer = PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }

    public function showCertificateIncharges() {
        $instituteIds = Institutecertificateincharge::pluck('institute_id')->toArray();

        $institutes = Institute::whereIn('id', $instituteIds)->where('active_status', 1)->orderBy('code')->get();

        return view('nber.institutes.show_certificate_incharges',compact('institutes'));
    }

    public function downloadCertificateIncharges() {
        $instituteIds = Institutecertificateincharge::pluck('institute_id')->toArray();

        $institutes = Institute::whereIn('id', $instituteIds)->where('active_status', 1)->orderBy('code')->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $styleArray = [
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
            ],
        ];

        $sheet->setCellValue('A1', 'S.No');
        $sheet->setCellValue('B1', 'Inst. Code');
        $sheet->setCellValue('C1', 'Inst. Name');
        $sheet->setCellValue('D1', 'Contact Details');
        $sheet->setCellValue('E1', 'District');
        $sheet->setCellValue('F1', 'State');
        $sheet->setCellValue('G1', 'Pincode');

        $sheet->getStyle('A1:I1')->getAlignment()->setWrapText(true);

        //setting Column Width
        $sheet->getColumnDimension('A')->setWidth(5, 'pt');
        $sheet->getColumnDimension('B')->setWidth(7, 'pt');
        $sheet->getColumnDimension('C')->setWidth(20, 'pt');
        $sheet->getColumnDimension('D')->setWidth(65, 'pt');
        $sheet->getColumnDimension('E')->setWidth(13, 'pt');
        $sheet->getColumnDimension('F')->setWidth(13, 'pt');

        $sheet->getStyle('A1:G1')->applyFromArray($styleArray);
        $sheet->getStyle('A1:G1')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('A1:G1')->getFont()->setBold(true);

        $sheet->getStyle('A1:G1')->getFont()->setName('Bookman Old Style');
        $sheet->getStyle('A1:G1')->getFont()->setSize(8);

        $rowCount = 2;
        $sno = 1;
        foreach ($institutes as $institute) {
            $address = $institute->institutecertificateincharge["name"]."\n".$institute->institutecertificateincharge["designation"]."\n";

            $address .= $institute->name." (".$institute->code.")\n";

            if($institute->street_address != '')
                $address .= $institute->street_address."\n";

            if(!is_null($institute->postoffice))
                $address .= $institute->postoffice."POST OFFICE \n";

            $district = "";
            $state = "";
            if($institute->city_id != 0) {
                $district = $institute->city->name;
                $state = $institute->city->state->state_name;

                $address .= $district." DIST., \n".$state;
            }

            if($institute->pincode != '')
                $address .= '-'.$institute->pincode;

            if($institute->landmark != '')
                $address .= "\nLandmark: ".$institute->landmark;

            if($institute->institutecertificateincharge["contactnumber1"] != '')
                $address .= "\nMob. No: ".$institute->institutecertificateincharge["contactnumber1"];

            if($institute->institutecertificateincharge["contactnumber2"] != '')
                $address .= ", ".$institute->institutecertificateincharge["contactnumber2"];

            $sheet->setCellValue('A'.$rowCount, $sno);
            $sheet->setCellValue('B'.$rowCount, $institute->code);
            $sheet->setCellValue('C'.$rowCount, $institute->name);
            $sheet->setCellValue('D'.$rowCount, $address);
            $sheet->setCellValue('E'.$rowCount, $district);
            $sheet->setCellValue('F'.$rowCount, $state);
            $sheet->setCellValue('G'.$rowCount, $institute->pincode);

            $sheet->getStyle('C'.$rowCount)->getAlignment()->setWrapText(true);
            $sheet->getStyle('D'.$rowCount)->getAlignment()->setWrapText(true);
            $sheet->getStyle('E'.$rowCount)->getAlignment()->setWrapText(true);
            $sheet->getStyle('F'.$rowCount)->getAlignment()->setWrapText(true);

            $sheet->getStyle('A'.$rowCount.':G'.$rowCount)->applyFromArray($styleArray);
            $sheet->getStyle('A'.$rowCount.':G'.$rowCount)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

            $sheet->getStyle('A'.$rowCount.':G'.$rowCount)->getFont()->setName('Bookman Old Style');
            $sheet->getStyle('A'.$rowCount.':G'.$rowCount)->getFont()->setSize(8);

            $rowCount++;
            $sno++;

            unset($address);
            unset($institute);
        }

        $sheet->getPageMargins()->setLeft(0.5);

        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
        $sheet->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 1);

        $sheet->getHeaderFooter()->setOddHeader('&C&H&B&"Bookman Old Style-" Details of Institute Certificate Incharges');
        $sheet->getHeaderFooter()->setOddFooter('&C&H&B&"Bookman Old Style-" Page &P of &N');

        $filename = 'Institutes Certificate Incharge Details.xlsx';
        ob_end_clean();
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');

        $writer = PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');

    }

    public function printCertificateIncharge($id) {
        $institute = Institute::find($id);

        $title = $institute->code.' - Print Certificate Incharge';

        $yearSpecification = (date('m') >= 4 ? date('Y').'-'.(date('y')+1) : (date('Y')-1).'-'.date('y'));

        return view('nber.institutes.print_certificate_incharge',compact('institute', 'title', 'yearSpecification'));
    }
}
