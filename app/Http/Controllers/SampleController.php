<?php

namespace App\Http\Controllers;
use App\Academicyear;
use App\Approvedprogramme;
use App\Candidate;
use App\Externalexamcenter;
use App\Institute;
use App\Institutecertificateincharge;
use App\Programme;
use Barryvdh\DomPDF\PDF;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

use App\Http\Requests;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpParser\Node\Scalar\MagicConst\Dir;
use PhpOffice\PhpSpreadsheet;
//use Excel;

class SampleController extends Controller
{
    //
    public function index() {
        Excel::create('clients', function ($excel){
            $excel->sheet('clients', function ($sheet){
                $sheet->loadview('sample');
            });
        })->export('xlsx');
    }

    public function accessSessionData(Request $request) {
        if($request->session()->has('my_name'))
            echo $request->session()->get('my_name');
        else
            echo 'No data in the session';
    }
    public function storeSessionData(Request $request) {
        $request->session()->put('my_name','Virat Gandhi');
        echo "Data has been added to session";
    }
    public function deleteSessionData(Request $request) {
        $request->session()->forget('my_name');
        echo "Data has been removed from session.";
    }

    public function passwordtoclos() {
        $senddata = array(
            array("externalexamcentercode" => "EXHP01", "name" => "Ms. Meera Bansa", "email" => "ggsss.nahan@gmail.com
"),
        );

        foreach ($senddata as $data) {
            $externalexamcenter = Externalexamcenter::where("code", $data["externalexamcentercode"])->first();

            if(!is_null($externalexamcenter)) {
                $to_name = $data["name"];
                $to_email = trim($data["email"]);

                Mail::send('passwordtoclos', ['externalexamcenter' => $externalexamcenter], function($message) use ($to_name, $to_email) {
                    $message->to($to_email, $to_name)
                        ->subject('Login Credentials for August 2021 Examinations');
                    $message->from('niepmd.examinations@gmail.com','NIEPMD-NBER, Chennai');
                });
            }
            else {
                echo $data["externalexamcentercode"]."<br>";
            }

        }
    }

    public function showpaymentform() {
        return view('samplepayment');
    }

    public function testingpaymentform() {
        return view('paymentgateway.testingpaymentform');
    }

    public function ccavRequestHandler(Request $request) {
        $data = $request->except('_token');

        //return view('paymentgateway.ccavRequestHandler', compact('data'));
    }

    public function ccavResponseHandler(Request $request) {
        return view('paymentgateway.ccavResponseHandler', $request);
    }

    public function testingredirecturl(Request $request) {
        return view('paymentgateway.ccavResponseHandler', compact('request'));
    }

    public function testingcancelurl(Request $request) {
        echo 'Something went wrong';
    }

    public function testingpaymentform1() {
        return view('paymentgateway1.testingpaymentform');
    }

    public function ccavRequestHandler1(Request $request) {
        $data = $request->except('_token');

        return view('paymentgateway1.ccavRequestHandler', compact('data'));
    }

    public function ccavResponseHandler1() {
        return view('paymentgateway1.ccavResponseHandler');
    }

    public function testingredirecturl1() {
        return view('paymentgateway1.ccavResponseHandler');
    }

    public function testingcancelurl1() {
        echo 'Something went wrong';
    }

    public function checkPaymentStatusForm() {
        require_once base_path().'/resources/views/paymentgateway/Crypto.blade.php';
        error_reporting(0);

        $data = [];
        $merchant_data = "";
        $data += ['merchant_id' => '692568'];
        $data += ['redirect_url' => 'https://www.examcell.niepmdexaminationsnber.com/paymentstatus'];
        $working_key='8D29080EBDBF0C2E451319B1183A12EF';//Shared by CCAVENUES
        $access_code='AVAY53IJ99BL03YALB';//Shared by CCAVENUES

        foreach ($data as $key => $value){
            if($merchant_data != "")
                $merchant_data .= "&";
            $merchant_data.=$key.'='.$value;
        }

        $encrypted_data=payment_encrypt($merchant_data,$working_key);

        echo $encrypted_data;

        /*
        echo '<form method="post" name="redirect" action="https://api.ccavenue.com/apis/servlet/DoWebTrans">';
        echo '<input type="hidden" name="encRequest" value="'.$encrypted_data.'">';
        echo '<input type="hidden" name="access_code" value="'.$access_code.'">';
        echo '<input type="hidden" name="request_type" value="JSON">';
        echo '<input type="hidden" name="response_type" value="JSON">';
        echo '<input type="hidden" name="command" value="orderStatusTracker">';
        echo '<input type="hidden" name="order_no" value="INPRJ53OR20220314113336RI9914">';
        echo '</form>';
        echo '<script language="javascript">document.redirect.submit();</script>';
        */
    }

    public function paymentStatus(Request $request) {
        require_once base_path().'/resources/views/paymentgateway/Crypto.blade.php';

        error_reporting(0);

        $workingKey='8D29080EBDBF0C2E451319B1183A12EF';		//Working Key should be provided here.
        $encResponse=$request->encResp;			//This is the response sent by the CCAvenue Server
        $rcvdString=payment_decrypt($encResponse,$workingKey);		//Crypto Decryption used as per the specified working key.
        $order_status="";
        $decryptValues=explode('&', $rcvdString);
        $dataSize=sizeof($decryptValues);

        for($i = 0; $i < $dataSize; $i++) {
            $information = explode('=', $decryptValues[$i]);
            echo $information[0].' => '.$information[1].'<br>';
        }
    }

    public function studentDetailsExcel($pid, $ayid) {
        $programme = Programme::find($pid);
        $academicyear = Academicyear::find($ayid);

        $title = "Details of Student - ".$programme->course_name.' - '.$academicyear->year;

        $collections = Candidate::select(['candidates.enrolmentno as candidateEnrolmentno', 'candidates.name as candidateName', 'institutes.code as instituteCode', 'institutes.name as instituteName'])
            ->join('approvedprogrammes', 'approvedprogrammes.id', '=', 'candidates.approvedprogramme_id')
            ->join('institutes', 'institutes.id', '=', 'approvedprogrammes.institute_id')
            ->where('approvedprogrammes.programme_id', $pid)
            ->where('approvedprogrammes.academicyear_id', $ayid)
            ->whereNotNull('candidates.enrolmentno')
            ->orderBy('institutes.code')
            ->orderBy('candidates.enrolmentno')
            ->get();

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
        $sheet->setCellValue('D1', 'Enrolment No');
        $sheet->setCellValue('E1', 'Name');

        $sheet->getStyle('A1:E1')->getAlignment()->setWrapText(true);

        //setting Column Width
        $sheet->getColumnDimension('A')->setWidth(5, 'pt');
        $sheet->getColumnDimension('B')->setWidth(7, 'pt');
        $sheet->getColumnDimension('C')->setWidth(65, 'pt');
        $sheet->getColumnDimension('D')->setWidth(15, 'pt');
        $sheet->getColumnDimension('E')->setWidth(20, 'pt');

        $sheet->getStyle('A1:E1')->applyFromArray($styleArray);
        $sheet->getStyle('A1:E1')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('A1:E1')->getFont()->setBold(true);

        $sheet->getStyle('A1:E1')->getFont()->setName('Bookman Old Style');
        $sheet->getStyle('A1:E1')->getFont()->setSize(8);

        $rowCount = 2;
        $sno = 1;
        foreach ($collections as $collection) {
            $sheet->setCellValue('A'.$rowCount, $sno);
            $sheet->setCellValue('B'.$rowCount, $collection->instituteCode);
            $sheet->setCellValue('C'.$rowCount, $collection->instituteName);
            $sheet->setCellValue('D'.$rowCount, $collection->candidateEnrolmentno);
            $sheet->setCellValue('E'.$rowCount, $collection->candidateName);

            $rowCount++;
            $sno++;
        }

        $sheet->getPageMargins()->setLeft(0.5);

        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
        $sheet->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 1);

        $sheet->getHeaderFooter()->setOddHeader('&C&H&B&"Bookman Old Style-" Details of Student List');
        $sheet->getHeaderFooter()->setOddFooter('&C&H&B&"Bookman Old Style-" Page &P of &N');

        $filename = 'Students List.xlsx';
        ob_end_clean();
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');

        $writer = PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }
}
