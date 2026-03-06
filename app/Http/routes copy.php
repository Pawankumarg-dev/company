<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
use App\Expert;
use Milon\Barcode\DNS1D;
use Milon\Barcode\DNS2D;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Barryvdh\Debugbar;

/*
Route::get('/demoemail', function(){
    $to_name = 'NBER Web';
    $to_email = 'nber.web@gmail.com';
    $data = array('name'=>"Sam Jose", "body" => "Test mail");

    Mail::send('sample', $data, function($message) use ($to_name, $to_email) {
        $message->to($to_email, $to_name)
            ->subject('Web Testing Mail');
        $message->from('niepmd.examinations@gmail.com','NIEPMD-NBER, Chennai');
    });
});
*/
Route::get('/sampletesting', function(){
   \App\User::find(1);
    Barryvdh\Debugbar\Facade::error("ji");
});

Route::get('/passwordtoclos', 'SampleController@passwordtoclos');
Route::get('/samplepayment', 'SampleController@showpaymentform');
Route::post('/testRequestHandler', 'SampleController@testRequestHandler');
Route::get('/testingpaymentform', 'SampleController@testingpaymentform');
Route::post('/ccavRequestHandler', 'SampleController@ccavRequestHandler');
Route::post('/testingredirecturl', 'SampleController@testingredirecturl');
Route::post('/testingcancelurl', 'SampleController@testingcancelurl');
Route::post('/ccavResponseHandler', 'SampleController@ccavResponseHandler');

Route::get('/testingpaymentform1', 'SampleController@testingpaymentform1');
Route::post('/ccavRequestHandler1', 'SampleController@ccavRequestHandler1');
Route::get('/testingredirecturl1', 'SampleController@testingredirecturl1');
Route::get('/testingcancelurl1', 'SampleController@testingcancelurl1');
Route::post('/ccavResponseHandler1', 'SampleController@ccavResponseHandler1');

Route::get('/checkpaymentstatusform', 'SampleController@checkPaymentStatusForm');
Route::post('/paymentstatus', 'SampleController@paymentStatus');

//Route::get('/correctionrequesttracking/{crn_id}',);

/*
Route::get('/testexcel', function(){
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setCellValue('A1', 'Hello World !');

    $writer = new Xlsx($spreadsheet);
    $writer->save('hello_world.xlsx');
});
*/

Route::get('session/get','SampleController@accessSessionData');
Route::get('session/set','SampleController@storeSessionData');
Route::get('session/remove','SampleController@deleteSessionData');

Route::get('/examresult/{exam_id}','Result\ResultController@index');
Route::post('/examresult/{exam_id}','Result\ResultController@check');
Route::get('/examresult/{exam_id}/{candidate_id}','Result\ResultController@showresult');
//Route::get('/excel', 'SampleController@index');

//Route::get('/examhallticket/{exam_id}', 'Hallticket\HallticketController@index');

Route::get('/reevaluationapplication/home/{eid}', 'Reevaluationapplication\HomeController@showhomepage');
Route::get('/reevaluationapplication/error', 'Reevaluationapplication\HomeController@showerrorpage');
Route::get('/reevaluationapplication/confirmcandidate/{eid}', 'Reevaluationapplication\HomeController@showcandidateconfirmpage');
Route::post('/reevaluationapplication/checkcandidatedetail', 'Reevaluationapplication\HomeController@checkcandidatedetail');
Route::get('/reevaluationapplication/newapplicationform/{eid}/{cid}', 'Reevaluationapplication\HomeController@newapplicationform');
Route::post('/reevaluationapplication/addapplication/', 'Reevaluationapplication\HomeController@addapplication');
Route::get('/reevaluationapplication/displayapplicationnumber/{eid}/{cid}', 'Reevaluationapplication\HomeController@displayapplicationnumber');
Route::post('/reevaluationapplication/login/checkapplicationnumber/', 'Reevaluationapplication\LoginController@checkapplicationnumber');
Route::get('/reevaluationapplication/login/showdashboard/{eid}/{appl_no}', 'Reevaluationapplication\LoginController@showdashboard');
Route::get('/reevaluationapplication/login/showsubjectdetailform/{eid}/{appl_no}', 'Reevaluationapplication\LoginController@showsubjectdetailform');
Route::post('/reevaluationapplication/login/addsubjectdetail/', 'Reevaluationapplication\LoginController@addsubjectdetail');
Route::get('/reevaluationapplication/login/showpaymentdetailform/{eid}/{appl_no}', 'Reevaluationapplication\LoginController@showpaymentdetailform');
Route::post('/reevaluationapplication/login/addpaymentdetail/', 'Reevaluationapplication\LoginController@addpaymentdetail');
Route::get('/reevaluationapplication/logout/{eid}', 'Reevaluationapplication\LoginController@logout');
Route::post('/reevaluationapplication/ajaxrequest/getcandidatedetails', 'Reevaluationapplication\HomeController@getcandidatedetails');
Route::post('/reevaluationapplication/ajaxrequest/sendmobileverificationcode', 'Reevaluationapplication\HomeController@sendmobileverificationcode');
Route::post('/reevaluationapplication/ajaxrequest/sendemailverificationcode', 'Reevaluationapplication\HomeController@sendemailverificationcode');

Route::get('/reevaluationresult/{exam_id}', 'Result\ResultController@reevaluation');
Route::post('/reevaluationresult/{exam_id}', 'Result\ResultController@reevaluationcheck');
Route::get('/reevaluationresult/{exam_id}/{candidate_id}', 'Result\ResultController@showreevaluationresult');
//Route::get('/update', 'Result\ResultController@update');

/*
Route::get('datedifference', function(){

    // My Birthday :)
    $date_1 = new DateTime( '2014-08-15' );

// Todays date
    $date_2 = new DateTime( '2016-04-29' );

    $difference = $date_2->diff( $date_1 );


// Echo the as string to display in browser for testing
    echo (string)$difference->y.".".(string)$difference->m.' years';


    echo date_diff($date_1, $date_2)->format('%y.0%m');
});
*/

/*
Route::get('/filedownload', function(){
    $doc_rci = \App\Candidate::where('id', '34162')->pluck('doc_rci')->toArray();

    $file = public_path()."/files/temp/".$doc_rci;

    $header = array(
        'Content-Type : application/jpg',
    );

    //return Response::download($file, "Photo.jpg");

    $info = pathinfo($file);

    $ext1 = $info['filename'];
    $ext2 = $info['extension'];
    $ext3 = $info['dirname'];
    $ext4 = $info['basename'];

    echo 'Dirname : '.$ext3.'<br>';
    echo 'Basename : '.$ext4.'<br>';
    echo 'Filename : '.$ext1.'<br>';
    echo 'Extension : '.$ext2.'<br>';


    $destination = public_path()."/files/enrolment/crr/";

    if (!rename($file, $destination)) {
        echo "failed to move $file...\n";
    }else{
        echo "moved $file into $destination\n";
    }

    /*
    //file copy
    if (!copy($file, $destination)) {
        echo "failed to copy $file...\n";
    }else{
        echo "copied $file into $destination\n";
    }

    //file move
    if (!rename($file, $destination)) {
        echo "failed to move $file...\n";
    }else{
        echo "moved $file into $destination\n";
    }

});
*/
Route::auth();

/*
Route::get('/barcode', function (){
    //echo DNS2D::getBarcodeHTML("4445645656", "QRCODE");
    echo DNS2D::getBarcodeHTML("KOTHANDARAMAN", "QRCODE");
    //echo DNS1D::getBarcodeHTML("4445645656", "PHARMA2T",3,33,"green", true);
    //echo DNS1D::getBarcodeHTML("4445645656", "C39");

    //echo DNS1D::getBarcodeSVG("4445645656", "PHARMA2T",3,33,"green", true);
    //echo DNS1D::getBarcodeHTML("4445645656", "PHARMA2T",3,33,"green", true);
    //echo '<img src="' . DNS1D::getBarcodePNG("4", "C39+",3,33,array(1,1,1), true) . '" alt="barcode"   />';
    //echo DNS1D::getBarcodePNGPath("4445645656", "PHARMA2T",3,33,array(255,255,0), true);
    //echo '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG("4", "C39+",3,33,array(1,1,1), true) . '" alt="barcode"   />';

    //echo DNS1D::getBarcodeSVG("DS191001", "C39");
    //echo DNS1D::getBarcodeHTML("4445645656", "PHARMA2T",3,33);
    echo DNS1D::getBarcodeSVG("4445645656", "PHARMA2T",3,33);
    echo DNS1D::getBarcodeHTML("4445645656", "PHARMA2T",3,33);
    echo '<img src="' . DNS1D::getBarcodePNG("4", "C39+",3,33) . '" alt="barcode"   />';
    echo DNS1D::getBarcodePNGPath("4445645656", "PHARMA2T",3,33);
    echo '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG("4", "C39+",3,33) . '" alt="barcode"   />';
});
*/
Route::get('/', 'HomeController@welcome');

Route::get('/examinerexperts/', 'Examinerexpert\HomeController@index');
Route::get('/examinerexperts/register', 'Examinerexpert\HomeController@register');
Route::get('/examinerexperts/register/check', 'Examinerexpert\HomeController@check');

// Routes for Expert
Route::get('/expert/', 'Expert\HomeController@index');
Route::get('/expert/application/new/', 'Expert\NewApplicationController@index');
Route::get('/expert/application/new/applystage/{stage_id}', 'Expert\NewApplicationController@applystage');
Route::post('/expert/application/new/checkstage1/', 'Expert\NewApplicationController@checkstage1');
Route::get('/expert/application/new/messagestage1/{expert_id}', array("as" => "/expert/application/stage1message", "uses" => "Expert\NewApplicationController@messagestage1"));

Route::post('/expert/application/new/stage2login', 'Expert\NewApplicationController@checkstage2login');
Route::get('/expert/application/new/applystage2/{expert_id}', array("as" => "/expert/application/applystage2", "uses" => "Expert\NewApplicationController@displaystage2"));
Route::post('/expert/application/new/checkstage2/', 'Expert\NewApplicationController@checkstage2');
Route::get('/expert/application/new/messagestage2/{expert_id}', array("as" => "/expert/application/stage2message", "uses" => "Expert\NewApplicationController@messagestage2"));

Route::post('/expert/application/new/stage3login', 'Expert\NewApplicationController@checkstage3login');
Route::get('/expert/application/new/applystage3/{expert_id}', array("as" => "/expert/application/applystage3", "uses" => "Expert\NewApplicationController@displaystage3"));
Route::get('/expert/application/new/displaystage3form/{expert_id}', 'Expert\NewApplicationController@displaystage3form');
Route::post('/expert/application/new/checkstage3qualifications', 'Expert\NewApplicationController@checkstage3qualifications');
Route::post('/expert/application/new/addstage3', 'Expert\NewApplicationController@addstage3');
Route::get('/expert/application/new/messagestage3/{expert_id}', array("as" => "/expert/application/stage3message", "uses" => "Expert\NewApplicationController@messagestage3"));

Route::post('/expert/application/new/stage4login', 'Expert\NewApplicationController@checkstage4login');
Route::get('/expert/application/new/applystage4/{expert_id}', array("as" => "/expert/application/applystage4", "uses" => "Expert\NewApplicationController@displaystage4"));
Route::get('/expert/application/new/displaystage4form/{expert_id}', 'Expert\NewApplicationController@displaystage4form');
Route::post('/expert/application/new/checkstage4qualifications', 'Expert\NewApplicationController@checkstage4qualifications');
Route::post('/expert/application/new/addstage4', 'Expert\NewApplicationController@addstage4');
Route::get('/expert/application/new/messagestage4/{expert_id}', array("as" => "/expert/application/stage4message", "uses" => "Expert\NewApplicationController@messagestage4"));

Route::post('/expert/application/new/stage5login', 'Expert\NewApplicationController@checkstage5login');
Route::get('/expert/application/new/applystage5/{expert_id}', array("as" => "/expert/application/applystage5", "uses" => "Expert\NewApplicationController@displaystage5"));
Route::post('/expert/application/new/checkstage5/', 'Expert\NewApplicationController@addstage5');
Route::get('/expert/application/new/messagestage5/{expert_id}', array("as" => "/expert/application/stage5message", "uses" => "Expert\NewApplicationController@messagestage5"));

Route::post('/expert/application/new/stage6login', 'Expert\NewApplicationController@checkstage6login');
Route::get('/expert/application/new/applystage6/{expert_id}', array("as" => "/expert/application/applystage6", "uses" => "Expert\NewApplicationController@displaystage6"));
Route::get('/expert/application/new/displaystage6form/{expert_id}', 'Expert\NewApplicationController@displaystage6form');
Route::post('/expert/application/new/checkstage6experiences', 'Expert\NewApplicationController@addstage6experiences');
Route::post('/expert/application/new/addstage6', 'Expert\NewApplicationController@addstage6');
Route::get('/expert/application/new/messagestage6/{expert_id}', array("as" => "/expert/application/stage6message", "uses" => "Expert\NewApplicationController@messagestage6"));

Route::post('/expert/application/new/stage7login', 'Expert\NewApplicationController@checkstage7login');
Route::get('/expert/application/new/applystage7/{expert_id}', array("as" => "/expert/application/applystage7", "uses" => "Expert\NewApplicationController@displaystage7"));
Route::get('/expert/application/new/displaystage7form/{expert_id}', 'Expert\NewApplicationController@displaystage7form');
Route::post('/expert/application/new/checkstage7experiences', 'Expert\NewApplicationController@addstage7experiences');
Route::post('/expert/application/new/addstage7', 'Expert\NewApplicationController@addstage7');
Route::get('/expert/application/new/messagestage7/{expert_id}', array("as" => "/expert/application/stage7message", "uses" => "Expert\NewApplicationController@messagestage7"));

Route::post('/expert/application/new/stage8login', 'Expert\NewApplicationController@checkstage8login');
Route::get('/expert/application/new/applystage8/{expert_id}', array("as" => "/expert/application/applystage8", "uses" => "Expert\NewApplicationController@displaystage8"));
Route::get('/expert/application/new/displaystage8form/{expert_id}', 'Expert\NewApplicationController@displaystage8form');
Route::post('/expert/application/new/checkstage8languages', 'Expert\NewApplicationController@addstage8languages');
Route::post('/expert/application/new/addstage8', 'Expert\NewApplicationController@addstage8');
Route::get('/expert/application/new/messagestage8/{expert_id}', array("as" => "/expert/application/stage8message", "uses" => "Expert\NewApplicationController@messagestage8"));

Route::post('/expert/application/new/stage9login', 'Expert\NewApplicationController@checkstage9login');
Route::get('/expert/application/new/applystage9/{expert_id}', array("as" => "/expert/application/applystage9", "uses" => "Expert\NewApplicationController@displaystage9"));
Route::post('/expert/application/new/checkstage9/', 'Expert\NewApplicationController@addstage9');
Route::get('/expert/application/new/messagestage9/{expert_id}', array("as" => "/expert/application/stage9message", "uses" => "Expert\NewApplicationController@messagestage9"));

Route::post('/expert/application/new/stage10login', 'Expert\NewApplicationController@checkstage10login');
Route::get('/expert/application/new/applystage10/{expert_id}', array("as" => "/expert/application/applystage10", "uses" => "Expert\NewApplicationController@displaystage10"));
Route::post('/expert/application/new/checkstage10/', 'Expert\NewApplicationController@addstage10');
Route::get('/expert/application/new/messagestage10/{expert_id}', array("as" => "/expert/application/stage10message", "uses" => "Expert\NewApplicationController@messagestage10"));

Route::get('/expert/application/print', 'Expert\PrintApplicationController@index');
Route::post('/expert/application/print/checklogin', 'Expert\PrintApplicationController@checklogin');
Route::get('/expert/application/print/{expert_id}', array("as" => "/expert/application/print", "uses" => "Expert\PrintApplicationController@printapplication"));

///// Edit Examination Experts

Route::get('/expert/application/edit', 'Expert\EditApplicationController@index');
Route::post('/expert/application/edit/checklogin/', 'Expert\EditApplicationController@checklogin');
Route::get('/expert/application/edit/{expert_id}', array("as" => "/expert/application/edit", "uses" => "Expert\EditApplicationController@showstages"));

Route::get('/expert/application/edit/stage1/display/{expert_id}', 'Expert\EditApplicationController@displaystage1');
Route::get('/expert/application/edit/stage1/form/{expert_id}', 'Expert\EditApplicationController@formstage1');
Route::post('/expert/application/edit/stage1/updateform', 'Expert\EditApplicationController@updatestage1');
Route::get('/expert/application/edit/stage1/message/{expert_id}', 'Expert\EditApplicationController@messagestage1');

Route::get('/expert/application/edit/stage2/display/{expert_id}', 'Expert\EditApplicationController@displaystage2');
Route::get('/expert/application/edit/stage2/form/{expert_id}', 'Expert\EditApplicationController@formstage2');
Route::post('/expert/application/edit/stage2/updateform', 'Expert\EditApplicationController@updatestage2');
Route::get('/expert/application/edit/stage2/message/{expert_id}', 'Expert\EditApplicationController@messagestage2');

Route::get('/expert/application/edit/stage3/display/{expert_id}', 'Expert\EditApplicationController@displaystage3');
Route::get('/expert/application/edit/stage3/form/{expertqualification_id}', 'Expert\EditApplicationController@formstage3');
Route::post('/expert/application/edit/stage3/updateform', 'Expert\EditApplicationController@updatestage3');
Route::get('/expert/application/edit/stage3/addform/{expert_id}', 'Expert\EditApplicationController@addformstage3');
Route::post('/expert/application/edit/stage3/checkaddform/', 'Expert\EditApplicationController@checkaddformstage3');
Route::get('/expert/application/edit/stage3/message/{expert_id}', 'Expert\EditApplicationController@messagestage3');
Route::get('/expert/application/edit/stage3/delete/{expertqualification_id}', 'Expert\EditApplicationController@deletestage3');

Route::get('/expert/application/edit/stage4/display/{expert_id}', 'Expert\EditApplicationController@displaystage4');
Route::get('/expert/application/edit/stage4/form/{expertrciqualification_id}', 'Expert\EditApplicationController@formstage4');
Route::post('/expert/application/edit/stage4/updateform', 'Expert\EditApplicationController@updatestage4');
Route::get('/expert/application/edit/stage4/addform/{expert_id}', 'Expert\EditApplicationController@addformstage4');
Route::post('/expert/application/edit/stage4/checkaddform/', 'Expert\EditApplicationController@checkaddformstage4');
Route::get('/expert/application/edit/stage4/message/{expert_id}', 'Expert\EditApplicationController@messagestage4');
Route::get('/expert/application/edit/stage4/delete/{expertrciqualification_id}', 'Expert\EditApplicationController@deletestage4');

Route::get('/expert/application/edit/stage5/display/{expert_id}', 'Expert\EditApplicationController@displaystage5');
Route::get('/expert/application/edit/stage5/form/{expert_id}', 'Expert\EditApplicationController@formstage5');
Route::post('/expert/application/edit/stage5/updateform', 'Expert\EditApplicationController@updatestage5');
Route::get('/expert/application/edit/stage5/message/{expert_id}', 'Expert\EditApplicationController@messagestage5');

Route::get('/expert/application/edit/stage6/display/{expert_id}', 'Expert\EditApplicationController@displaystage6');
Route::get('/expert/application/edit/stage6/form/{expertqualification_id}', 'Expert\EditApplicationController@formstage6');
Route::post('/expert/application/edit/stage6/updateform', 'Expert\EditApplicationController@updatestage6');
Route::get('/expert/application/edit/stage6/addform/{expert_id}', 'Expert\EditApplicationController@addformstage6');
Route::post('/expert/application/edit/stage6/checkaddform/', 'Expert\EditApplicationController@checkaddformstage6');
Route::get('/expert/application/edit/stage6/message/{expert_id}', 'Expert\EditApplicationController@messagestage6');
Route::get('/expert/application/edit/stage6/delete/{expertqualification_id}', 'Expert\EditApplicationController@deletestage6');

Route::get('/expert/application/edit/stage7/display/{expert_id}', 'Expert\EditApplicationController@displaystage7');
Route::get('/expert/application/edit/stage7/form/{expertqualification_id}', 'Expert\EditApplicationController@formstage7');
Route::post('/expert/application/edit/stage7/updateform', 'Expert\EditApplicationController@updatestage7');
Route::get('/expert/application/edit/stage7/addform/{expert_id}', 'Expert\EditApplicationController@addformstage7');
Route::post('/expert/application/edit/stage7/checkaddform/', 'Expert\EditApplicationController@checkaddformstage7');
Route::get('/expert/application/edit/stage7/message/{expert_id}', 'Expert\EditApplicationController@messagestage7');
Route::get('/expert/application/edit/stage7/delete/{expertqualification_id}', 'Expert\EditApplicationController@deletestage7');

Route::get('/expert/application/edit/stage8/display/{expert_id}', 'Expert\EditApplicationController@displaystage8');
Route::get('/expert/application/edit/stage8/form/{expertlanguage_id}', 'Expert\EditApplicationController@formstage8');
Route::post('/expert/application/edit/stage8/updateform', 'Expert\EditApplicationController@updatestage8');
Route::get('/expert/application/edit/stage8/addform/{expert_id}', 'Expert\EditApplicationController@addformstage8');
Route::post('/expert/application/edit/stage8/checkaddform/', 'Expert\EditApplicationController@checkaddformstage8');
Route::get('/expert/application/edit/stage8/message/{expert_id}', 'Expert\EditApplicationController@messagestage8');
Route::get('/expert/application/edit/stage8/delete/{expertlanguage_id}', 'Expert\EditApplicationController@deletestage8');

Route::get('/expert/application/edit/stage9/display/{expert_id}', 'Expert\EditApplicationController@displaystage9');
Route::get('/expert/application/edit/stage9/form/{expert_id}', 'Expert\EditApplicationController@formstage9');
Route::post('/expert/application/edit/stage9/updateform', 'Expert\EditApplicationController@updatestage9');
Route::get('/expert/application/edit/stage9/message/{expert_id}', 'Expert\EditApplicationController@messagestage9');
// ./Routes for Expert

Route::get('/externalexamcenter/', 'Externalexamcenter\HomeController@index');
Route::post('/externalexamcenter/checklogin', 'Externalexamcenter\HomeController@checklogin');
Route::get('/externalexamcenter/showhomepage/{exc_id}', 'Externalexamcenter\HomeController@showhomepage');
Route::get('/externalexamcenter/{exc_id}/show-home-page/{exam_id}', 'Externalexamcenter\HomeController@show_home_page');
Route::get('/externalexamcenter/{exc_id}/show-attendance-sheet/{exam_id}', 'Externalexamcenter\HomeController@show_attendance_sheet');
Route::get('/externalexamcenter/{exc_id}/attendance-sheet/{exam_id}/show-exam-schedules', 'Externalexamcenter\HomeController@showExamSchedules');
Route::get('/externalexamcenter/{exc_id}/attendance-sheet/{exam_id}/view-attendances/{et_startdate}', 'Externalexamcenter\HomeController@viewAttendanceSheets');
Route::get('/externalexamcenter/{exc_id}/attendance-sheet/{exam_id}/show-markattendance-forms/{et_startdate}', 'Externalexamcenter\HomeController@showmarkattendanceforms');
Route::get('/externalexamcenter/{exc_id}/attendance-sheet/{exam_id}/show-markabsent-forms/{et_startdate}', 'Externalexamcenter\HomeController@showmarkabsenteeforms');
Route::get('/externalexamcenter/{exc_id}/attendance-sheet/{exam_id}/show-markedattendances/{et_startdate}', 'Externalexamcenter\HomeController@showmarkedattendances');
Route::get('/externalexamcenter/{exc_id}/attendance-sheet/{exam_id}/show-markedabsentees/{et_startdate}', 'Externalexamcenter\HomeController@showmarkedabsentees');
Route::post('/externalexamcenter/markattendances', 'Externalexamcenter\HomeController@markattendanceforms');
Route::post('/externalexamcenter/markabsentees', 'Externalexamcenter\HomeController@markabsenteesforms');
Route::get('/externalexamcenter/{exc_id}/download-attendance-sheet/{et_id}', 'Externalexamcenter\HomeController@download_attendance_sheet');
Route::get('/externalexamcenter/{exc_id}/show-question-papers/{exam_id}', 'Externalexamcenter\HomeController@show_question_papers');
Route::get('/externalexamcenter/{exc_id}/show-demo-question-papers/{exam_id}', 'Externalexamcenter\HomeController@show_demo_question_papers');
Route::get('/externalexamcenter/download-question-papers/{et_id}', 'Externalexamcenter\HomeController@download_question_papers');
Route::get('/externalexamcenter/attendance/downloadsheet/{e_id}/{exc_id}/{et_id}', 'Externalexamcenter\HomeController@viewAttendanceSheets');
Route::get('/externalexamcenter/attendance/showlist/{e_id}/{exc_id}/{et_id}', 'Externalexamcenter\AttendanceController@showattendancelist');
Route::get('/externalexamcenter/attendance/markattendanceform/{e_id}/{exc_id}/{et_id}', 'Externalexamcenter\AttendanceController@showinstitutes');
Route::get('/externalexamcenter/attendance/markattendanceform/{e_id}/{exc_id}/{et_id}/{ap_id}', 'Externalexamcenter\AttendanceController@markattendanceform');
Route::get('/externalexamcenter/attendance/updatemarkedattendanceform/{e_id}/{exc_id}/{et_id}/{ap_id}', 'Externalexamcenter\AttendanceController@updatemarkedattendanceform');
Route::post('/externalexamcenter/attendance/add/', 'Externalexamcenter\AttendanceController@addattendances');
Route::post('/externalexamcenter/attendance/update/', 'Externalexamcenter\AttendanceController@updateattendances');
//Route::post('institute/practicalexam/', 'Externalexamcenter\AttendanceController@updateattendances');
Route::get('/externalexamcenter/attendance/showenteredmarks/{e_id}/{exc_id}/{et_id}/{apid}', 'Externalexamcenter\AttendanceController@showmarkedattendances');
Route::get('/externalexamcenter/attendance/updateattendancesheetform/{e_id}/{exc_id}/{et_id}/{apid}', 'Externalexamcenter\AttendanceController@updateattendancesheetform');
Route::post('/externalexamcenter/attendance/updateattendancesheet/', 'Externalexamcenter\AttendanceController@updateattendancesheet');

Route::get('/externalexamcenter/questionpaper/showlist/{e_id}/{exc_id}/', 'Externalexamcenter\QuestionpaperController@showquestionpapers');

Route::get('/externalexamcenter/subject1/', 'Externalexamcenter\HomeController@downloadpaper1');
Route::get('/externalexamcenter/subject2/', 'Externalexamcenter\HomeController@downloadpaper2');
Route::get('/externalexamcenter/subject3/', 'Externalexamcenter\HomeController@downloadpaper3');
Route::get('/externalexamcenter/getinfo1/', 'Externalexamcenter\HomeController@getinfo1');
Route::get('/externalexamcenter/getinfo2/', 'Externalexamcenter\HomeController@getinfo2');
Route::get('/externalexamcenter/getinfo3/', 'Externalexamcenter\HomeController@getinfo3');
Route::get('/externalexamcenter/getquestionpaperdownloadinfo/', 'Externalexamcenter\QuestionpaperController@getquestionpaperdownloadinfo');
Route::get('/externalexamcenter/demo/markattendances/showupdate/attendances', 'Externalexamcenter\DemoController@showupdateattendances');
Route::post('/externalexamcenter/demo/markattendances/updateattendances', 'Externalexamcenter\DemoController@updateattendances');

Route::get('/demoexternalexamcenter/', 'Externalexamcenter\DemoController@index');
Route::post('/demoexternalexamcenter/checklogin', 'Externalexamcenter\DemoController@checklogin');
Route::get('/demoexternalexamcenter/showhomepage', 'Externalexamcenter\DemoController@showhomepage');
Route::get('/demoexternalexamcenter/demoattendancesheet', 'Externalexamcenter\DemoController@demoattendancesheet');
Route::get('/demoexternalexamcenter/demoattendancesheet/download/{id}', 'Externalexamcenter\DemoController@downloaddemoattendancesheet');
Route::get('/demoexternalexamcenter/demoquestionpaper', 'Externalexamcenter\DemoController@demoquestionpaper');
Route::get('/demoexternalexamcenter/downloaddemoquestionpaper/{id}', 'Externalexamcenter\DemoController@downloaddemoquestionpaper');
Route::get('/demoexternalexamcenter/demoattendancesheet/markattendance/{id}', 'Externalexamcenter\DemoController@markattendance');
Route::post('/demoexternalexamcenter/demoattendancesheet/addattendance/', 'Externalexamcenter\DemoController@addattendance');
Route::get('/demoexternalexamcenter/demoattendancesheet/viewmarkedattendance/{id}', 'Externalexamcenter\DemoController@viewmarkedattendance');

Route::get('/online-provisional-certificate/', 'Certification\CertificationController@index');
Route::post('/online-provisional-certificate/', 'Certification\CertificationController@checkcredentials');
Route::get('/online-provisional-certificate/{cand_id}/{folio_no}', 'Certification\CertificationController@download');

Route::get('/evaluationcenter/', 'Evaluationcenter\LoginController@index');
Route::post('/evaluationcenter/checklogin', 'Evaluationcenter\LoginController@checklogin');
//Route::get('/evaluationcenter/{ecid}/{eid}', 'Evaluationcenter\LoginController@showhome');
Route::get('/evaluationcenter/{ecid}', 'Evaluationcenter\LoginController@showHomePage');
Route::get('/evaluationcenter/{ecid}/{eid}', 'Evaluationcenter\LoginController@showBundleNumbers');
Route::get('/evaluationcenter/printfoilsheet/{ecid}/{eid}/{bundle_no}', 'Evaluationcenter\LoginController@printfoilsheet');
Route::get('/evaluationcenter/printbundlenos/{ecid}/{eid}', 'Evaluationcenter\LoginController@printbundlenos');
Route::get('/evaluationcenter/marks/showform/{ecid}/{eid}/{bundle_no}', 'Evaluationcenter\LoginController@showmarkforms');
Route::get('/evaluationcenter/marks/viewmarks/{ecid}/{eid}/{bundle_no}', 'Evaluationcenter\LoginController@viewmarks');
Route::post('/evaluationcenter/updatemarks/', 'Evaluationcenter\LoginController@updatemarks');
Route::get('/evaluationcenter/showquestionpapers/{exid}/{evcid}', 'Evaluationcenter\QuestionpaperController@showquestionpapers');
Route::get('/evaluationcenter/downloadquestionpaper/{exttid}', 'Evaluationcenter\QuestionpaperController@downloadquestionpaper');
Route::get('/evaluationcenter/onlineattendance/showonlineattendance/{ecid}/{eid}/{bundle_no}', 'Evaluationcenter\AttendanceController@showonlineattendance');
Route::get('/evaluationcenter/onlineattendance/updateonlineattendanceform/{ecid}/{eid}/{bundle_no}', 'Evaluationcenter\AttendanceController@updateonlineattendanceform');
Route::post('/evaluationcenter/onlineattendance/updateonlineattendance', 'Evaluationcenter\AttendanceController@updateonlineattendance');

Route::get('/tracking/correctionrequest/', 'Tracking\CorrectionrequestController@index');
Route::post('/tracking/correctionrequest/checkdetails/', 'Tracking\CorrectionrequestController@checkdetails');
Route::get('/tracking/correctionrequest/{ref_no}', 'Tracking\CorrectionrequestController@showdetails');

Route::get('/get-student-details-excel/{pid}/{ayid}', 'SampleController@studentDetailsExcel');


Route::group(array('middleware' => ['rci']), function ()
{
    Route::get('/rci/dashboard','Rci\DashboardController@index');
    Route::get('/rci/masterdb/nbers','Rci\NberController@index');
    Route::get('/nbers/create','Rci\NberController@store');
    Route::get('/nbers/update','Rci\NberController@update');
    Route::get('/rci/masterdb/programmegroups','Rci\ProgrammegroupController@index');
    Route::get('programmegroups/create','Rci\ProgrammegroupController@create');
    Route::get('programmegroups/update','Rci\ProgrammegroupController@update');
    Route::get('/rci/masterdb/programmes','Rci\ProgrammeController@index');
    Route::get('programmes/create','Rci\ProgrammeController@create');
    Route::get('programmes/update','Rci\ProgrammeController@update');
    Route::get('/rci/masterdb/academicyears','Rci\AcademicyearController@index');
    Route::get('/defineincidentalpayments','Rci\AcademicyearController@defineincidentalpayments');
    Route::get('/incidentalcharges/update','Rci\AcademicyearController@updateincidentalfee');
    Route::get('/academicyears/create','Rci\AcademicyearController@create');
    Route::get('/academicyears/update','Rci\AcademicyearController@update');
    Route::get('/rci/masterdb/institutes/','Rci\InstituteController@index');
    Route::get('/rci/institute/show/{id}','Rci\InstituteController@show');
	Route::get('/rci/changeayid/{id}','Rci\AcademicyearController@changeayid');
    Route::get('/rci/admissions/','Rci\AcademicController@index');
    Route::get('/institutes/create','Rci\InstituteController@create');
    Route::get('/institutes/update','Rci\InstituteController@update');
    Route::get('/academics/update','Rci\AcademicController@update');
    Route::post('/academics/delete','Rci\AcademicController@delete');
    Route::get('/academics/create','Rci\AcademicController@create');

});

Route::group(array('middleware' => ['institute']), function ()
{
	Route::get('/programmeslist','Institute\ProgrammeController@index');
	Route::post('/approvedprogramme','Institute\ApprovedprogrammeController@store');
	Route::post('/approvedprogramme/{id}/edit','Institute\ApprovedprogrammeController@update');
	Route::post('/approvedprogramme/{id}/delete','Institute\ApprovedprogrammeController@destroy');
	Route::get('/pdf/{id}','Institute\ApprovedprogrammeController@pdf');
	Route::get('/deleteapfile/{id}','Institute\ApprovedprogrammeController@deletefile');	
	
	Route::get('/candidate/create/{id}','Institute\CandidateController@create');
    Route::post('/getdistricts','Institute\CandidateController@getDistricts');
    Route::post('/getsubdistricts','Institute\CandidateController@getsubDistricts');
    Route::post('/getblocks','Institute\CandidateController@getBlocks');

	Route::post('/candidate','Institute\CandidateController@store');
	Route::get('/candidate/edit/{id}','Institute\CandidateController@edit');
	Route::get('/candidate/delete/{id}','Institute\CandidateController@delete');
	Route::post('/candidate/update/{id}','Institute\CandidateController@update');
	Route::get('/programme/{id}','Institute\CandidateController@index');
	Route::get('/studentlogin/{id}','Institute\CandidateController@studentlogin');
	
	Route::post('/fileupload','Institute\FileController@upload');
	Route::post('/cropimage','Institute\FileController@crop');
	
	Route::get('/payment','Institute\PaymentController@index');
	Route::get('/payments/create','Institute\PaymentController@create');
	Route::post('/payments/store','Institute\PaymentController@store');
	Route::get('/payments/pdf/{id}','Institute\PaymentController@pdf');

	Route::get('/applications/{id}/{exam_id}','Institute\ExamController@register');
	Route::post('/apply/','Institute\ExamController@apply');
	Route::get('/applications/pdf/exam/{ap_id}/{exam_id}','Institute\ExamController@exampdf');
    Route::get('/applications/pdf/payment/{ap_id}/{exam_id}','Institute\ExamController@paymentpdf');

	Route::get('/marks/{approvedprogramme_id}/{exam_id}','Institute\MarkController@index');
	Route::post('/updatemark','Institute\MarkController@update');
	Route::get('/markabs/{mid}/{inex}','Institute\MarkController@markabsent');
	Route::get('/marks/pdf/{approvedprogramme_id}/{exam_id}','Institute\MarkController@markpdf');

	Route::get('/hallticket','Institute\HallticketController@download');
	Route::get('/halltickets/{id}/{exam_id}','Institute\HallticketController@index');
	Route::post('/attendance','Institute\HallticketController@attendance');
	Route::post('/uploadattendance','Institute\HallticketController@uploadattendance');

	Route::get('/examinations','Institute\ExamController@index');

	Route::get('/institute/examinations','Institute\ExaminationController@index');
	Route::get('/institute/examinations/{e_id}','Institute\ExaminationController@showlists');
	Route::get('/institute/examinations/applications/{e_id}','Institute\ExaminationController@showApplications');
	Route::get('/institute/examinations/applications/{e_id}/{ap_id}','Institute\ExaminationController@showCandidateLists');
	Route::get('/institute/examinations/applications/{e_id}/{ap_id}/{c_id}','Institute\ExaminationController@viewCandidateApplication');
	Route::get('/institute/examinations/candidateapplication/{e_id}/{ap_id}/{c_id}','Institute\ExaminationController@candidateExamApplicationForm');
	Route::post('/institute/examinations/ajaxrequest/checkmobilenumberexist','Institute\ExaminationController@checkMobileNumberExist');
	Route::post('/institute/examinations/ajaxrequest/sendmobilenumberverificationcode','Institute\ExaminationController@sendMobileNumberVerificationCode');
    Route::post('/institute/examinations/ajaxrequest/checkemailaddressexist','Institute\ExaminationController@checkEmailAddressExist');
	Route::post('/institute/examinations/ajaxrequest/sendemailaddressverificationcode','Institute\ExaminationController@sendEmailAddressVerificationCode');
	Route::post('/institute/examinations/applycandidateexamapplication','Institute\ExaminationController@applyCandidateExamApplication');
    Route::get('/institute/examinations/ajaxrequest/getexamcentres', 'Institute\ExaminationController@getExamCentres');
    Route::post('/institute/enrolment/ajaxrequest/updateverificationstatus', 'Institute\CandidateController@updateverificationstatus');
    
	Route::get('/institute/examinations/practicalexaminers/{e_id}','Institute\ExaminationController@practicalexaminers');
	Route::get('result/{e_id}/{p_id}','Institute\ExaminationController@viewpracticalexaminers');
	Route::get('/institute/examinations/practicalexaminers/addfeedetails/{e_id}/{common_code}','Institute\ExaminationController@addfeedetails');
	Route::get('/institute/examinations/practicalexaminers/addexamdetails/{e_id}/{common_code}','Institute\ExaminationController@addexamdetails');
	Route::post('/institute/examinations/practicalexaminers/updateexamfee/','Institute\ExaminationController@updateexamfee');
	Route::post('/institute/examinations/practicalexaminers/updatepracticalexam/','Institute\ExaminationController@updatepracticalexam');
	Route::get('/institute/examinations/practicalexaminers/add/{e_id}/{p_id}','Institute\ExaminationController@addpracticalexaminers');
	Route::get('/institute/examinations/practicalexaminers/examinerdetails/{e_id}/{pe_id}','Institute\ExaminationController@examinerdetails');
	Route::get('/institute/examinations/practicalexaminers/addinternalexaminer/{e_id}/{pe_id}','Institute\ExaminationController@addinternalexaminer');
    Route::post('/institute/examinations/practicalexaminers/updateinternalexaminer/','Institute\ExaminationController@updateinternalexaminer');
	Route::get('/institute/examinations/practicalexaminers/addexternalexaminer/{e_id}/{pe_id}','Institute\ExaminationController@addexternalexaminer');
    Route::post('/institute/examinations/practicalexaminers/updateexternalexaminer/','Institute\ExaminationController@updateexternalexaminer');

	Route::get('/institute/examinations/applications/showcandidates/{e_id}/{ap_id}', 'Institute\ExamapplicationController@showcandidates');

    Route::get('/qpdownload/{exam_id}','Institute\ExamController@qpdownloads');
	Route::get('/downloadfile/questionpaper/{et_id}','Institute\ExamController@qpdownload');
	Route::get('student/{id}','Institute\CandidateController@show');
	Route::get('searchcandidates','Institute\CandidateController@search');

	Route::post('exam/upload/report/{examtimetable_id}','Institute\ExamattendanceController@uploadattendance');

	/*-- Exam Results --*/
    Route::get('/institute/examinations/results/{e_id}', 'Institute\ResultController@showlist');
    Route::get('/institute/examinations/results/{e_id}/{ap_id}', 'Institute\ResultController@showstudentslist');
	/*-- ./Exam Results --*/

    Route::get('/result/{exam_id}/{approvedprogramme_id}', 'Institute\ResultController@index');

    //Route::get('/institute/centerinformation/{id}', 'Institute\CenterinformationController@index');
    //Route::post('/institute/centerinformation/{id}', 'Institute\CenterinformationController@check');
    //Route::get('/institute/centerinformation/update/{id}/{r}', 'Institute\CenterinformationController@addoredit');

    Route::get('/centerinformation', 'Institute\CenterinformationController@index');
    Route::get('/institute/dashboard', 'Institute\DashboardController@index');
    Route::get('/institute/dashboard/home', 'Institute\DashboardController@homepage');

    //Route::get('/institute/info', 'Institute\InstituteController@index');

    Route::get('/institute/enrolment', 'Institute\EnrolmentController@index');
    Route::get('/enrolment', 'Institute\EnrolmentController@index');
    Route::get('/enrolment/new', 'Institute\EnrolmentController@newEnrolment');
    Route::post('/enrolment/checkCourse', 'Institute\EnrolmentController@checkCourse');
    Route::get('/enrolment/addfile/{ap_id}', 'Institute\EnrolmentController@addFile');
    Route::post('/enrolment/addfilecheck', 'Institute\EnrolmentController@addFilecheck');
    Route::get('/enrolment/editfile/{ap_id}', 'Institute\EnrolmentController@editFile');
    Route::post('/enrolment/editfilecheck', 'Institute\EnrolmentController@editFilecheck');

    Route::get('/institute/payment/enrolment', 'Institute\EnrolmentpaymentController@index');
    //Route::get('/institute/payment/enrolment/academicyear/{academicyear_id}', 'Institute\EnrolmentpaymentController@selectyear');
    Route::get('/institute/payment/enrolment/approvedprogramme/{approvedprogramme_id}', 'Institute\EnrolmentpaymentController@selectcourse');
    Route::post('/institute/payment/enrolment/appprovedprogramme/{approvedprogramme_id}', 'Institute\EnrolmentpaymentController@selectstudent');

    //CheckingEnrolmentPayments
    Route::get('/institute/enrolmentpayments', 'Institute\EnrolmentpaymentController@index');
    //Route::get('/institute/enrolmentpayments/{ayid}', 'Institute\EnrolmentpaymentController@showAcademicYear');
    Route::get('/institute/enrolmentpayments/{apid}', 'Institute\EnrolmentpaymentController@showCourses');
    Route::get('/institute/enrolmentpayments/checkenrolmentfee/{ayid}', 'Institute\EnrolmentpaymentController@checkenrolmentfee');
    Route::get('/institute/enrolmentpayments/showstudents/{apid}', 'Institute\EnrolmentpaymentController@showStudents');
    Route::get('/institute/enrolmentpayments/student/{cid}', 'Institute\EnrolmentpaymentController@addpaymentform');
    Route::get('/institute/enrolmentpayments/viewstudentpaymentdetails/{cid}', 'Institute\EnrolmentpaymentController@viewstudentpaymentdetails');
    Route::post('/institute/enrolmentpayments/addpaymentdetails/', 'Institute\EnrolmentpaymentController@addpaymentdetails');
    Route::get('/institute/enrolmentpayments/selectstudents/{ayid}', 'Institute\EnrolmentpaymentController@selectstudents');
    Route::post('/institute/enrolmentpayments/checkselectedstudents', 'Institute\EnrolmentpaymentController@checkselectedstudents');
    Route::get('/institute/enrolmentpayments/addpayment/{payment_date}/{candidate_ids}', 'Institute\EnrolmentpaymentController@addpayment');
    Route::post('/institute/enrolmentpayments/checkpayment', 'Institute\EnrolmentpaymentController@checkpayment');
    Route::get('/institute/enrolmentpayments/downloadreceipt/{reference_number}', 'Institute\EnrolmentpaymentController@downloadreceipt');

    //Online Enrolment Payment
    Route::get('/institute/enrolmentpayments/showonlinepaymentform/{cid}', 'Institute\EnrolmentpaymentController@showOnlinePaymentForm');
    Route::post('/institute/enrolmentpayments/ccavenuepaymentgatewayrequesthandler/', 'Institute\EnrolmentpaymentController@ccavenuePaymentGatewayRequestHandler');
    Route::get('/institute/enrolmentpayments/ccavenuepaymentgatewayresponsehandler/', 'Institute\EnrolmentpaymentController@ccavenuePaymentGatewayResponseHandler');
    Route::get('/institute/enrolmentpayments/ccavenuepaymentgatewaypaymentstatus/{order_num}', 'Institute\EnrolmentpaymentController@ccavenuePaymentGatewayPaymentStatus');
    Route::post('/institute/enrolmentpayments/ccavenuepaymentgatewayfailpage/', 'Institute\EnrolmentpaymentController@ccavenuePaymentGatewayFailPage');

    Route::get('/institute/examinationpayments', 'Institute\ExaminationpaymentController@index');
    Route::get('/institute/examinationpayments/showcourses/{eid}', 'Institute\ExaminationpaymentController@showcourses');
    Route::get('/institute/examinationpayments/showstudents/{eid}/{apid}', 'Institute\ExaminationpaymentController@showStudents');
    Route::get('/institute/examinationpayments/sampleshowstudents/{eid}/{apid}', 'Institute\ExaminationpaymentController@showSampleStudents');
    Route::get('/institute/examinationpayments/addpayment/{exam_id}/{candidate_id}', 'Institute\ExaminationpaymentController@addpayment');
    Route::post('/institute/examinationpayments/checkpayment', 'Institute\ExaminationpaymentController@checkpayment');
    Route::get('/institute/examinationpayments/viewstudentreceipt/{eid}/{apid}', 'Institute\ExaminationpaymentController@viewstudentreceipt');
    Route::get('/institute/examinationpayments/viewstudentpaymentdetails/{eid}/{cid}', 'Institute\ExaminationpaymentController@viewStudentPaymentDetails');
    Route::get('/institute/examinationpayments/downloadstudentreceipt/{expid}', 'Institute\ExaminationpaymentController@downloadstudentreceipt');
    Route::get('/institute/examinationpayments/showonlinepaymentform/{exid}/{cid}', 'Institute\ExaminationpaymentController@showOnlinePaymentForm');
    Route::post('/institute/examinationpayments/ccavenuepaymentgatewayrequesthandler/', 'Institute\ExaminationpaymentController@ccavenuePaymentGatewayRequestHandler');
    Route::post('/institute/examinationpayments/ccavenuepaymentgatewayresponsehandler/', 'Institute\ExaminationpaymentController@ccavenuePaymentGatewayResponseHandler');
    Route::get('/institute/examinationpayments/ccavenuepaymentgatewaypaymentstatus/{order_num}', 'Institute\ExaminationpaymentController@ccavenuePaymentGatewayPaymentStatus');
    Route::post('/institute/examinationpayments/ccavenuepaymentgatewayfailpage/', 'Institute\ExaminationpaymentController@ccavenuePaymentGatewayFailPage');
    //Route::get('/institute/examinationpayments/showexams', 'Institute\ExaminationpaymentController@showexams');
    //Route::get('/institute/examinationpayments/showexamcourselist/{e_id}/{id}', 'Institute\ExaminationpaymentController@showexamcourselist');
    //Route::get('/institute/examinationpayments/selectstudents', 'Institute\ExaminationpaymentController@selectstudents');
    ///Route::post('/institute/examinationpayments/checkselectedstudents', 'Institute\ExaminationpaymentController@checkselectedstudents');
    //Route::get('/institute/examinationpayments/addpayment/{payment_date}/{candidate_ids}/{exam_id}', 'Institute\ExaminationpaymentController@addpayment');
    //Route::get('/institute/examinationpayments/download/{exam_id}/{reference_number}', 'Institute\ExaminationpaymentController@downloadreceipt');


    Route::get('/institute/exammarksentry/{exam_id}/showlist/{approvedprogramme_id}', 'Institute\MarkEntryController@index');
    Route::get('/institute/exammarksentry/{exam_id}/showform/{candidate_id}', 'Institute\MarkEntryController@showform');
    Route::post('/institute/exammarksentry/updateform/', 'Institute\MarkEntryController@updateform');
    Route::get('/institute/exammarksentry/{exam_id}/downloadmarks/{ap_id}', 'Institute\MarkEntryController@downloadmarks');
    Route::get('/institute/exammarksentry/{exam_id}/view-internal-theory-marks/{ap_id}', 'Institute\MarkEntryController@viewinternaltheorymarks');
    Route::get('/institute/exammarksentry/{exam_id}/download-internal-theory-marks/{ap_id}', 'Institute\MarkEntryController@downloadinternaltheorymarks');
    Route::get('/institute/exammarksentry/{exam_id}/view-internal-practical-marks/{ap_id}', 'Institute\MarkEntryController@viewinternalpracticalmarks');
    //Route::get('/institute/exammarksentry/{exam_id}/view-external-practical-marks/{ap_id}', 'Institute\MarkEntryController@viewexternalpracticalmarks');

    Route::get('/institute/exammarksentry/{exam_id}/view-candidate-marks/{c_id}', 'Institute\MarkEntryController@view_candidate_marks');

    Route::get('/institute/exammarksentry/internal-theory/add-form/{exam_id}/{ap_id}', 'Institute\MarkEntryController@showInternalTheoryMarksForm');
    Route::post('/institute/exammarksentry/update-internal-theory-marks/', 'Institute\MarkEntryController@updateInternalTheoryMarks');
    Route::get('/institute/exammarksentry/internal-theory/view/{exam_id}/{ap_id}', 'Institute\MarkEntryController@viewinternaltheorymarks');
    //Route::get('/institute/exammarksentry/download-internal-theory-markentry-form/{exam_id}/{ap_id}', 'Institute\MarkEntryController@downloadInternalTheoryMarkEntryForm');
    Route::get('/institute/exammarksentry/download-internal-theory-markentry-form/', 'Institute\MarkEntryController@downloadInternalTheoryMarkEntryForms');
    Route::get('/institute/exammarksentry/internal-practical/add-form/{exam_id}/{ap_id}', 'Institute\MarkEntryController@showInternalPracticalMarksForm');
    Route::post('/institute/exammarksentry/update-internal-practical-marks/', 'Institute\MarkEntryController@updateInternalPracticalMarks');
    Route::get('/institute/exammarksentry/internal-practical/view/{exam_id}/{ap_id}', 'Institute\MarkEntryController@viewInternalPracticalMarks');
    Route::get('/institute/exammarksentry/external-practical/add-form/{exam_id}/{ap_id}', 'Institute\MarkEntryController@showExternalPracticalMarksForm');
    Route::post('/institute/exammarksentry/update-external-practical-marks/', 'Institute\MarkEntryController@updateExternalPracticalMarks');
    //Route::post('/institute/exammarksentry/external-practical/update-marks/', 'Institute\MarkEntryController@updateExternalPracticalMarks');
    Route::get('/institute/exammarksentry/download-internal-practical-markentry-form/', 'Institute\MarkEntryController@downloadInternalPracticalMarkEntryForms');
    Route::get('/institute/exammarksentry/download-external-practical-markentry-form/', 'Institute\MarkEntryController@downloadExternalPracticalMarkEntryForms');
    Route::get('/institute/exammarksentry/external-practical/view/{exam_id}/{ap_id}', 'Institute\MarkEntryController@viewExternalPracticalMarks');

    //new
    Route::get('/institute/dashboard', 'Institute\DashboardController@index');
    Route::get('/institute/center-information', 'Institute\CenterinformationController@index');
    Route::get('/institute/center-information/getcities/{state_id}', 'Institute\CenterinformationController@getcities');
    Route::get('get-city-list','Institute\CenterinformationController@getCityList');
    //Route::post('/institute/center-information/update', 'Institute\CenterinformationController@update_information');
    Route::post('/institute/center-information/update', 'Institute\CenterinformationController@updateInformation');
    Route::get('/institute/center-information/notifications', 'Institute\CenterinformationController@showNotifications');
    Route::post('/institute/center-information/ajaxrequest/checkemailaddressexist', 'Institute\CenterinformationController@checkEmailAddressExist');
    Route::post('/institute/center-information/ajaxrequest/sendemailaddressverificationcode', 'Institute\CenterinformationController@sendEmailAddressVerificationCode');

    Route::get('/institute/class-attendance/', 'Institute\ClassAttendanceController@index');
    Route::get('/institute/class-attendance/add-attendance/{ap_id}/term/{term_no}', 'Institute\ClassAttendanceController@add_class_attendance');

    Route::get('/institute/hallticket-download/{exam_id}/show-candidates-list/{ap_id}', 'Institute\HallticketController@showCandidatesList');
    Route::get('/institute/hallticket-download/showcandidateslist/{exam_id}/{ap_id}', 'Institute\HallticketController@showCandidatesList');
    //Route::get('/institute/hallticket-download/{exam_id}/enrolments/view/candidates/{c_id}', 'Institute\HallticketController@download_candidates_hallticket');
    Route::get('/institute/hallticket-download/{exam_id}/download-candidates-hallticket/{c_id}', 'Institute\HallticketController@downloadCandidateHallticket');
    Route::get('/institute/hallticket-download/download-candidate-hallticket/{exam_id}/{c_id}', 'Institute\HallticketController@downloadCandidateHallticket');

    Route::get('/institute/practicalexam/{exam_id}/showpage/{ap_id}', 'Institute\PracticalexamController@index');
    Route::get('/institute/practicalexam/{exam_id}/showcandidates/{ap_id}', 'Institute\PracticalexamController@showCandidates');
    Route::get('/institute/practicalexam/{exam_id}/showsubjects/{ap_id}', 'Institute\PracticalexamController@showSubjects');
    Route::get('/institute/practicalexam/{exam_id}/downloadhallticket/{cand_id}', 'Institute\PracticalexamController@downloadHallticket');
    Route::get('/institute/practicalexam/{exam_id}/downloadattendancesheet/{ap_id}/{sub_id}', 'Institute\PracticalexamController@downloadAttendanceSheet');

    Route::get('/institute/incidentalpayments', 'Institute\IncidentalchargeController@index');
    Route::get('/institute/incidentalpayments/{ayid}', 'Institute\IncidentalchargeController@showDetails');
    Route::get('/institute/incidentalpayments/addform/{ayid}/{apid}/{infid}', 'Institute\IncidentalchargeController@selectCourses');
    Route::post('/institute/incidentalpayments/addpaymentdetails', 'Institute\IncidentalchargeController@addPaymentDetails');
    Route::get('/institute/incidentalpayments/download/{inf_id}', 'Institute\IncidentalchargeController@downloadreceipt');
    Route::get('/institute/incidentalpayments/showonlinepaymentform/{ayid}/{apid}/{infid}', 'Institute\IncidentalchargeController@showOnlinePaymentForm');
    Route::post('/institute/incidentalpayments/ccavenuepaymentgatewayrequesthandler/', 'Institute\IncidentalchargeController@ccavenuePaymentGatewayRequestHandler');
    Route::post('/institute/incidentalpayments/ccavenuepaymentgatewayresponsehandler/', 'Institute\IncidentalchargeController@ccavenuePaymentGatewayResponseHandler');
    Route::get('/institute/incidentalpayments/ccavenuepaymentgatewaypaymentstatus/{order_num}', 'Institute\IncidentalchargeController@ccavenuePaymentGatewayPaymentStatus');
    Route::get('/institute/testing', 'Institute\IncidentalchargeController@testing');
    Route::post('/institute/incidentalpayments/ccavenuepaymentgatewayfailpage/', 'Institute\IncidentalchargeController@ccavenuePaymentGatewayFailPage');
    /* Certifications */
    Route::get('/institute/certifications/', 'Institute\CertificationController@index');
    Route::get('/institute/certifications/provisionals/', 'Institute\CertificationController@showprovisionalpage');
    Route::get('/institute/certifications/provisionals/download/{cand_id}', 'Institute\CertificationController@downloadprovisional');
    Route::get('/institute/certifications/marksheets/', 'Institute\CertificationController@showmarksheetspage');
    Route::get('/institute/certifications/marksheets/{examid}/{apid}', 'Institute\CertificationController@showmarksheetcandidateslist');
    /* ---Certifications--- */

    Route::get('/institute/coursecoordinators', 'Institute\CourseCoordinatorController@index');
    Route::get('/institute/coursecoordinators/create', 'Institute\CourseCoordinatorController@create');
    Route::post('/institute/coursecoordinators/save', 'Institute\CourseCoordinatorController@save');
    Route::get('/institute/coursecoordinators/download/{id}', 'Institute\CourseCoordinatorController@download');
    Route::get('/institute/coursecoordinators/ajaxrequest/checkaadhaarcardnumber', 'Institute\CourseCoordinatorController@checkaadhaarcardnumber');
    Route::get('/institute/coursecoordinators/ajaxrequest/checkmobilenumber', 'Institute\CourseCoordinatorController@checkmobilenumber');
    Route::get('/institute/coursecoordinators/ajaxrequest/checkwhatsappnumber', 'Institute\CourseCoordinatorController@checkwhatsappnumber');
    Route::get('/institute/coursecoordinators/ajaxrequest/checkemailaddress', 'Institute\CourseCoordinatorController@checkemailaddress');
    Route::get('/institute/coursecoordinators/ajaxrequest/getcityid', 'Institute\CourseCoordinatorController@getcityid');
    Route::get('/institute/coursecoordinators/ajaxrequest/registrationnumber', 'Institute\CourseCoordinatorController@checkregistrationnumber');
    Route::get('/institute/coursecoordinators/ajaxrequest/getcoursecoordinatorcoursemode', 'Institute\CourseCoordinatorController@getcoursecoordinatorcoursemode');
    Route::get('/institute/coursecoordinators/ajaxrequest/getcoursecoordinatorcourseid', 'Institute\CourseCoordinatorController@getcoursecoordinatorcourseid');
    Route::post('/institute/coursecoordinators/adddetails', 'Institute\CourseCoordinatorController@addDetails');
    Route::post('/institute/coursecoordinators/ajaxrequest/sendmobilenumberverificationcode','Institute\CourseCoordinatorController@sendMobileNumberVerificationCode');
    Route::post('/institute/coursecoordinators/ajaxrequest/sendemailaddressverificationcode','Institute\CourseCoordinatorController@sendEmailAddressVerificationCode');

    Route::get('/institute/consolidatedclassattendance/{eid}', 'Institute\AttendancePercentageController@home');
    Route::get('/institute/consolidatedclassattendance/theory/updateform/{eid}/{apid}/{term}', 'Institute\AttendancePercentageController@updateTheoryAttendancePercentageForm');
    Route::get('/institute/ExamTimeTables/{eid}', 'Institute\ExamTimetableController@home');
    Route::get('/institute/ExamTimetables/theory/update/{eid}/{apid}/{term}', 'Institute\ExamTimetableController@updateTheoryEXam');
});

Route::group(array('middleware' => ['nber']), function ()
{
     Route::get('/nber/settings','Nber\DashboardController@settings');
     Route::get('/nber/settings/update','Nber\DashboardController@updatesettings');
     Route::get('/nber/dashboard', 'Nber\DashboardController@index');
	 Route::post('/cropimageadmin','Nber\CandidateController@crop');
	 Route::get('/programmeapplications', 'Nber\ApprovedprogrammeController@index');
	 Route::get('/programme/{status_id}/{id}','Nber\ApprovedprogrammeController@changestatus');
	 Route::get('/candidateapplications','Nber\CandidateController@index');
	 Route::get('/candidate/{status_id}/{id}','Nber\CandidateController@changestatus');
	 Route::get('/candidate/{id}','Nber\CandidateController@show');
	
     /* Institute */
	 Route::get('/institutes/','Nber\InstituteController@index');
	 Route::get('/nber/institutes/showinstitutes','Nber\InstituteController@showInstitutes');
	 Route::get('/nber/institutes/downloadinstitutesaddress','Nber\InstituteController@downloadInstitutesAddress');
	 Route::get('/nber/institutes/printinstituteaddress/{inst_id}', ['as' => 'instituteaddress.print', 'uses' => 'Nber\InstituteController@printInstituteAddress']);
	 Route::get('/nber/institutes/showcertificateincharges','Nber\InstituteController@showCertificateIncharges');
     Route::get('/nber/institutes/downloadcertificateincharges','Nber\InstituteController@downloadCertificateIncharges');
     Route::get('/nber/institutes/printcertificateincharge/{inst_id}', ['as' => 'institutecertificateincharge.print', 'uses' => 'Nber\InstituteController@printCertificateIncharge']);
	 Route::get('/nber/institutes/showcoursecoordinators','Nber\CourseCoordinatorController@showCourseCoordinators');
	 Route::get('/institute/{id}','Nber\InstituteController@show');

	 Route::get('/payments/','Nber\PaymentController@index');
	 Route::get('/payments/{status_id}/{id}','Nber\PaymentController@changestatus');
	 Route::get('/settings','Nber\ProgrammegroupController@settings');
	 Route::get('/generateenrolment/{id}','Nber\ApprovedprogrammeController@generateenrolment');
	 Route::post('updateenno','Nber\ApprovedprogrammeController@updateenno');
	 Route::get('importscript','Nber\ApprovedprogrammeController@import');
	 Route::get('subjects/create','Nber\SubjectController@create');
	 Route::get('subjects/update','Nber\SubjectController@update');
	 Route::get('subjects/{id}','Nber\SubjectController@index');
	 Route::get('changeayid/{id}','Nber\DashboardController@changeayid');
	 Route::get('examapplications','Nber\ExamapplicationController@index');
	 Route::get('exappstatus/{id}','Nber\ExamapplicationController@updatestatus');
	 Route::get('/examtypes','Nber\ExamtypeController@index');
	 Route::get('/examtypes/create','Nber\ExamtypeController@create');
	 Route::get('/examtypes/update','Nber\ExamtypeController@update');
	 Route::get('/exams','Nber\ExamController@index');
	 Route::get('/batches/create','Nber\ExamController@create');
	 Route::get('/exams/update','Nber\ExamController@update');
	 Route::get('/evaluation/{id}','Nber\ExamController@show');
	 Route::get('/evaluation/{exam}/{programme}','Nber\ExamController@showinstitutes');
	 Route::get('/evaluation/{exam_id}/{programme_id}/{institute_id}','Nber\ExamController@showmarks');
	 Route::get('/publishexam/{exam_id}','Nber\ExamController@publish');
	 Route::get('/examtimetables','Nber\ExamtimetableController@index');
     Route::get('/examcontrols','Nber\ExamController@controls');
     Route::get('/batch/settings/{id}','Nber\ExamController@batchsettings');
     Route::get('batchsettings/update','Nber\ExamController@updatebatchsettings');
     Route::get('/batches/update','Nber\ExamController@updateexamname');
	 Route::get('/questionpapers','Nber\ExamtimetableController@questionpapers');
	 Route::post('/uploadquestionpaper','Nber\ExamtimetableController@uploadquestionpaper');	 
	 Route::get('/examtimetables/create','Nber\ExamtimetableController@create');
	 Route::get('/examtimetables/update','Nber\ExamtimetableController@update');
	 Route::get('/examcenters','Nber\ExamtimetableController@examcenters');
	 Route::get('/examcenters/update','Nber\ExamtimetableController@updateexamcenter');
	 Route::get('/search','Nber\SearchController@search');
	 Route::get('/attendanceapplications','Nber\HallticketController@approveattendances');
	 Route::get('/changeexemption/{e}','Nber\HallticketController@changeexemption');
	 Route::post('/markupdate','Nber\MarkController@update');
	 Route::get('/markabsnber/{mid}/{inex}','Nber\MarkController@markabsent');
	 Route::get('/cloreportfiles','Nber\CloreportfileController@index');
	 Route::get('/cloreportfiles/create','Nber\CloreportfileController@create');
	 Route::get('/cloreportfiles/update','Nber\CloreportfileController@update');
	 Route::get('/cloreportfiles','Nber\CloreportfileController@index');
	 Route::get('/cloreportfiles/create','Nber\CloreportfileController@create');
	 Route::get('/cloreportfiles/update','Nber\CloreportfileController@update');

	 Route::get('/examattendancefiles','Nber\ExamattendancefileController@index');
	 Route::get('/examattendancefiles/create','Nber\ExamattendancefileController@create');
	 Route::get('/examattendancefiles/update','Nber\ExamattendancefileController@update');
	 Route::get('/clos','Nber\CloController@index');

	 Route::get('/marksverify/{exam_id}','Nber\ExamController@selectcourse');
	 Route::get('/marksverify/{exam_id}/{programme_id}','Nber\ExamController@selectinstitute');
     Route::get('/marksverify/{exam_id}/{programme_id}/{institute_id}','Nber\ExamController@selectyear');
     //Route::get('/marksverify/{exam_id}/{programme_id}/{institute_id}/{approvedprogramme_id}','Nber\ExamController@markspdf');
     Route::get('/verifymarks/{exam_id}/{approvedprogramme_id}','Nber\ExamController@verifymarks');
     //Route::get('/exam/{exam_id}/marks/export/', 'Nber\ExportExcelController@export');

     Route::get('/downloads/', 'Nber\DownloadController@index');
     Route::get('/downloads/fullmarks/{exam_id}', 'Nber\DownloadController@downloadmarks');
     //Route::get('/downloads/full-course-marks/{exam_id}/{programme_id}/{academicyear_id}', 'Nber\DownloadController@downloadMarks');
     Route::get('/downloads/{exam_id}/{programme_id}/{academicyear_id}', 'Nber\DownloadController@showInstitutes');
     Route::get('/downloads/{exam_id}/{approvedprogramme_id}', 'Nber\DownloadController@exportmarks');
     //Route::get('/downloads/{exam_id}/{approvedprogramme_id}', 'Nber\DownloadController@downloadCourseBatchMarks');
     Route::get('/download-fullmarks/{exam_id}/{programme_id}/{academicyear_id}', 'Nber\DownloadController@downloadFullMarks');
     Route::get('/download-photos/{exam_id}/{approvedprogramme_id}', 'Nber\DownloadController@showCandidates');
    Route::get('/downloads/coursemarks/{exam_id}/{programme_id}/{academicyear_id}', 'Nber\DownloadController@downloadCourseMarks');
     //Route::get('/download-photos/{candidate_id}', 'Nber\DownloadController@downloadphotos');
    Route::get('/downloads/full-course-marks/{exam_id}/{programme_id}/{academicyear_id}', 'Nber\DownloadController@exportCourseBatchFullMarks');

     Route::get('/download-photos/{candidate_id}', 'Nber\DownloadController@downloadphotos')->name('download-photos');

     //Route::get('/sort', 'Nber\DownloadController@selectyear');

    Route::get('/nber/payments/', 'Nber\PaymentController@payments');
    // Enrolment Payments
    Route::get('/nber/payments/enrolment/', 'Nber\EnrolmentPaymentController@index');
    Route::get('/nber/payments/enrolment/{ay_id}', 'Nber\EnrolmentPaymentController@showInstituteLists');
    Route::get('/nber/payments/enrolment/showcourselists/{ay_id}/{inst_id}', 'Nber\EnrolmentPaymentController@showcourselists');
    Route::get('/nber/payments/enrolment/showstudentlists/{ay_id}/{ap_id}', 'Nber\EnrolmentPaymentController@showstudentlists');
    Route::get('/nber/payments/enrolment/viewstudentpaymentdetails/{c_id}', 'Nber\EnrolmentPaymentController@viewstudentpaymentdetails');
    Route::get('/nber/payments/enrolment/{ay_id}/{inst_id}', 'Nber\EnrolmentPaymentController@showPaymentDetails');
    Route::post('/nber/payments/enrolment/update-status/', 'Nber\EnrolmentPaymentController@updateStatus');
    Route::get('/nber/payments/enrolment-receipt/{ref_number}', 'Nber\EnrolmentPaymentController@downloadreceipt');

    //Route::get('/nber/payments/examination/', 'Nber\ExaminationPaymentController@index');
    Route::get('/nber/examinationpayments/', 'Nber\ExaminationPaymentController@index');
    Route::get('/nber/examinationpayments/showverificationstatus/{exam_id}', 'Nber\ExaminationPaymentController@showVerificationStatus');
    Route::get('/nber/examinationpayments/showverificationpending/institutelists/{exam_id}', 'Nber\ExaminationPaymentController@showVerificationPendingInstituteLists');
    Route::get('/nber/examinationpayments/showpending/institutelists/{exam_id}', 'Nber\ExaminationPaymentController@showPendingInstituteLists');
    Route::get('/nber/examinationpayments/showapproved/institutelists/{exam_id}', 'Nber\ExaminationPaymentController@showApprovedInstituteLists');
    Route::get('/nber/examinationpayments/showrejected/institutelists/{exam_id}', 'Nber\ExaminationPaymentController@showRejectedInstituteLists');
    Route::get('/nber/examinationpayments/showverificationpending/institute/{exam_id}/{institute_id}', 'Nber\ExaminationPaymentController@showInstituteVerificationPendingDetails');
    Route::get('/nber/examinationpayments/showpending/institute/{exam_id}/{institute_id}', 'Nber\ExaminationPaymentController@showInstitutePendingDetails');
    Route::get('/nber/examinationpayments/showapproved/institute/{exam_id}/{institute_id}', 'Nber\ExaminationPaymentController@showInstituteApprovedDetails');
    Route::get('/nber/examinationpayments/showrejected/institute/{exam_id}/{institute_id}', 'Nber\ExaminationPaymentController@showInstituteRejectedDetails');
    //Route::get('/nber/examinationpayments/showverificationstatus/institute/{exam_id}/{institute_id}', 'Nber\ExaminationPaymentController@showInstituteVerificationPendingDetails');
    Route::get('/nber/examinationpayments/{exam_id}', 'Nber\ExaminationPaymentController@showInstituteLists');
    Route::get('/nber/examinationpayments/showverificationpendinglist/{exam_id}', 'Nber\ExaminationPaymentController@viewVerificationPendingLists');
    Route::get('/nber/examinationpayments/showapprovedlist/{exam_id}', 'Nber\ExaminationPaymentController@viewApprovedLists');
    Route::get('/nber/examinationpayments/showpendinglist/{exam_id}', 'Nber\ExaminationPaymentController@viewPendingLists');
    Route::get('/nber/examinationpayments/showrejectedlist/{exam_id}', 'Nber\ExaminationPaymentController@viewRejectedLists');
    Route::get('/nber/examinationpayments/paymentdetails/{exam_id}/{exampayment_id}', 'Nber\ExaminationPaymentController@viewCandidatePaymentDetails');
    Route::post('/nber/examinationpayments/updateverificationremarks', 'Nber\ExaminationPaymentController@updateVerificationRemarks');
    //Route::get('/nber/payments/examination/{exam_id}', 'Nber\ExaminationPaymentController@showInstituteLists');
    //Route::get('/nber/payments/examination/{exam_id}/{inst_id}', 'Nber\ExaminationPaymentController@showPaymentDetails');
    //Route::post('/nber/payments/examination/update-status/', 'Nber\ExaminationPaymentController@updateStatus');
    //Route::get('/nber/payments/examination-receipt/{ref_number}', 'Nber\ExaminationPaymentController@viewReceipt');
    Route::get('/nber/examinationpayments/approved-payment/{exam_id}', 'Nber\ExaminationPaymentController@downloadApprovedPayment');

    Route::post('/newpayments/examination/view/', 'Nber\ExaminationPaymentController@view');
    Route::get('/nber/payments/incidentalcharge/', 'Nber\IncidentalchargePaymentController@index');
    Route::get('/nber/payments/incidentalcharge/viewinstitutes/{ay_id}', 'Nber\IncidentalchargePaymentController@viewInstitutes');
    Route::get('/nber/payments/incidentalcharge/{ay_id}/', 'Nber\IncidentalchargePaymentController@showinstitutes');
    Route::get('/nber/payments/incidentalcharge/{ay_id}/{inst_id}', 'Nber\IncidentalchargePaymentController@showinstitutepayments');
    Route::get('/nber/payments/incidentalcharge/{ay_id}/{ap_id}/{term}', 'Nber\IncidentalchargePaymentController@showpaymentdetails');
    Route::get('/nber/payments/incidentalcharge/receipt/{ref_no}', 'Nber\IncidentalchargePaymentController@viewreceipt');
    Route::post('/nber/payments/incidentalcharge/updatestatus/', 'Nber\IncidentalchargePaymentController@updatestatus');

	Route::get('/nber/payments/reevaluation/', 'Nber\ReevaluationPaymentController@index');
	Route::get('/nber/payments/reevaluation/{e_id}', 'Nber\ReevaluationPaymentController@showApplications');
	Route::get('/nber/payments/reevaluation/{e_id}/{reevaluationapplication_id}', 'Nber\ReevaluationPaymentController@showReevaluationApplication');
	Route::post('/nber/payments/reevaluation/updatestatus/', 'Nber\ReevaluationPaymentController@updatestatus');

    Route::get('/nber/dashboard/', 'Nber\DashboardController@index');

    Route::get('/nber/samplepayments/{exam_id}', 'Nber\ExaminationPaymentController@sampleexampayments');

    Route::get('/nber/examresults/', 'Nber\ResultController@index');
    Route::get('/nber/examresults/{exam_id}', 'Nber\ResultController@form');
    //Route::get('/nber/examresults/{exam_id}', 'Nber\ResultController@showCandidateList');
    Route::post('/nber/examresult/checkresult/', 'Nber\ResultController@checkresult');
    Route::get('/nber/examresult/viewresult/{exam_id}/{candidate_id}', array("as" => "/nber/examresult/viewresult", "uses" => "Nber\ResultController@viewresult"));

    Route::get('/nber/examapplications/{e_id}', 'Nber\ExamapplicationController@showapplieddetails');
    /*
    Route::get('/nber/examapplications/', 'Nber\ExamapplicationController@index');
    Route::get('/nber/examapplications/{exam_id}/show-batches', 'Nber\ExamapplicationController@showbatches');
    Route::get('/nber/examapplications/{exam_id}/show-candidates/{ap_id}', 'Nber\ExamapplicationController@showcandidates');
    Route::get('/nber/examapplications/{exam_id}/show-candidate-applications/{cand_id}', 'Nber\ExamapplicationController@showapplications');
    Route::get('/nber/examapplications/edit-candidate-application/{app_id}', 'Nber\ExamapplicationController@deleteapplication');
    */
    Route::get('/nber/exam-experts/', 'Nber\ExpertController@index');

    Route::get('/nber/exam-centers', 'Nber\ExamcenterController@index');
    Route::get('/nber/exam-centers/{exam_id}', 'Nber\ExamcenterController@index');
    Route::get('/nber/exam-centers/{exam_id}/download-students-count/{excenter_id}', 'Nber\ExamcenterController@download_students_count1');
    Route::get('/nber/exam-centers/{exam_id}/show-attendance-list/{detail_id}', 'Nber\ExamcenterController@show_attendance_list');
    Route::get('/nber/exam-centers/{exam_id}/show-attendance-list2/{detail_id}', 'Nber\ExamcenterController@show_attendance_list2');

    Route::get('/nber/exam-marksentry/show-exams-list', 'Nber\MarkEntryController@show_exams_list');

    /* BASLP Exam */
    Route::get('/nber/baslp-exam/', 'Nber\BaslpController@index');
    Route::get('/nber/baslp-exam/{e_id}/show-examcenters-list/', 'Nber\BaslpController@show_examcenters_list');
    Route::get('/nber/baslp-exam/{e_id}/show-candidates-list/{exc_id}', 'Nber\BaslpController@show_candidates_list');
    Route::get('/nber/baslp-exam/download-candidate-hallticket/{exd_id}', 'Nber\BaslpController@download_candidate_hallticket');
    /* ./BASLP Exam */

    Route::get('/nber/exams', 'Nber\ExamController@show_exam_list');
    /* Exam Marks Entry */
    //Route::get('/nber/exams', 'Nber\MarkEntryController@index');
    Route::get('/nber/exams/marks-entry/{e_id}/show-applied-list', 'Nber\MarkEntryController@show_applied_list');
    Route::get('/nber/exams/marks-entry/{e_id}/show-subjects/{ap_id}', 'Nber\MarkEntryController@show_subjects');
    Route::get('/nber/exams/marks-entry/{e_id}/update-marks/{ap_id}/subject/{s_id}', 'Nber\MarkEntryController@show_form');
    Route::post('/nber/exams/marks-entry/updateform/', 'Nber\MarkEntryController@update_marks');
    Route::get('/nber/exams/marks-entry/{e_id}/show-marks/{ap_id}/subject/{s_id}', 'Nber\MarkEntryController@show_marks');
    /* ./Exam Marks Entry */

    /* Exam Marks Verify */
    Route::get('/nber/exams/marks-verify/{e_id}/show-applied-list', 'Nber\MarkVerifyController@show_applied_list');
    Route::get('/nber/exams/marks-verify/{e_id}/theory-marks/{ap_id}', 'Nber\MarkVerifyController@show_theory_marks');
    Route::get('/nber/exams/marks-verify/{e_id}/practical-marks/{ap_id}', 'Nber\MarkVerifyController@show_practical_marks');
    Route::get('/nber/exams/marks-verify/{e_id}/show-marks/{ap_id}', 'Nber\MarkVerifyController@show_marks');

    Route::get('/nber/exams/marks-verify/internal-theory/{e_id}/{ap_id}', 'Nber\MarkVerifyController@view_internal_theory_marks');
    Route::get('/nber/exams/marks-verify/external-theory/{e_id}/{ap_id}', 'Nber\MarkVerifyController@view_external_theory_marks');
    Route::get('/nber/exams/marks-verify/internal-practical/{e_id}/{ap_id}', 'Nber\MarkVerifyController@view_internal_practical_marks');
    Route::get('/nber/exams/marks-verify/external-practical/{e_id}/{ap_id}', 'Nber\MarkVerifyController@view_external_practical_marks');

    Route::get('/nber/exams/practical/{e_id}/showlists', 'Nber\PracticalexamController@showLists');
    Route::get('/nber/exams/practical/{e_id}/showlistsexcel', 'Nber\PracticalexamController@showlistsexcel');
    Route::get('/nber/exams/practical/{e_id}/showsubjects/{ap_id}', 'Nber\PracticalexamController@showSubjects');
    Route::get('/nber/exams/practical/{e_id}/downloadattendancesheet/{ap_id}/{sub_id}', 'Nber\PracticalexamController@downloadAttendanceSheet');

    Route::get('/nber/exams/theory/{e_id}/showlists', 'Nber\TheoryexamController@showLists');
    Route::get('/nber/exams/theory/{e_id}/showlistsexcel', 'Nber\TheoryexamController@showlistsexcel');
    Route::get('/nber/exams/theory/{e_id}/showsubjects/{ap_id}', 'Nber\TheoryexamController@showSubjects');
    Route::get('/nber/exams/theory/{e_id}/downloadattendancesheet/{ap_id}/{sub_id}', 'Nber\TheoryexamController@downloadAttendanceSheet');
    /* ./Exam Marks Verify */

    /* Correction Query */
    Route::get('/nber/correction-query', 'Nber\CorrectionQueryController@index');
    /*
    Route::get('/nber/correction-query/new-entry', 'Nber\CorrectionQueryController@select_candidate');
    Route::post('/nber/correction-query/new-entry/check-candidate', 'Nber\CorrectionQueryController@check_candidate');
    Route::get('/nber/correction-query/new-entry/candidate/{candidate_id}', array("as" => "/nber/correction-query/new-entry/candidate/", "uses" => "Nber\CorrectionQueryController@add_new_entry_form"));
    */
    Route::get('/nber/correction-query/select-candidate/', 'Nber\CorrectionQueryController@select_candidate');
    Route::post('/nber/correction-query/check-candidate/', 'Nber\CorrectionQueryController@check_candidate');
    Route::get('/nber/correction-query/confirm-candidate/{type}/{candidate_id}/', array("as" => "/nber/correction-query/confirm-candidate/", "uses" => "Nber\CorrectionQueryController@confirm_candidate"));

    Route::post('/nber/correction-query/check-confirm-candidate/', 'Nber\CorrectionQueryController@check_confirm_candidate');
    Route::get('/correction-query/show-correction-page/{code}/', array("as" => "/correction-query/show-correction-page/", "uses" => "Nber\CorrectionQueryController@showCorrectionPage"));
    /* ./Correction Query */
    Route::get('/nber/exams/reevaluation/', 'Nber\ReevaluationController@index');
    Route::get('/nber/reevaluation/{e_id}', 'Nber\ReevaluationController@showApplications');
    Route::get('/nber/reevaluation/downloadapplications/{e_id}/', 'Nber\ReevaluationController@downloadApplications');
    Route::get('/nber/reevaluation/{e_id}/{rapp_id}', 'Nber\ReevaluationController@showCandidateApplication');

    Route::get('/nber/enrolments/', 'Nber\EnrolmentController@index');
    Route::get('/enrolments/{ay_id}/institute-list/', 'Nber\EnrolmentController@showInstituteList');
    Route::get('/nber/enrolments/showcourseapprovalverificationdetails/{ay_id}', 'Nber\EnrolmentController@showCourseApprovalVerificationDetails');
    Route::get('/nber/enrolments/showapprovedprogrammeslist/{ay_id}/{status_id}', 'Nber\EnrolmentController@showApprovedprogrammesList');
    Route::get('/nber/enrolments/download-approvedprogrammeslist/{ay_id}/{status_id}', 'Nber\EnrolmentController@downloadApprovedprogrammesList');
    Route::get('enrolments/approvalstatus/{ayid}', 'Nber\EnrolmentController@showapprovalstatus');
    Route::get('/nber/enrolments/course/approve/{apid}', 'Nber\EnrolmentController@approveCourse');
    Route::get('/nber/enrolments/course/hold/{apid}', 'Nber\EnrolmentController@holdCourse');
    Route::get('/nber/enrolments/course/reject/{apid}', 'Nber\EnrolmentController@rejectCourse');
    Route::get('/nber/enrolments/course/delete/{apid}', 'Nber\EnrolmentController@deleteCourse');
    Route::get('/enrolments/view/candidates/', 'Nber\EnrolmentController@viewCandidates');
    Route::get('/enrolments/editform/candidate/{candid}', 'Nber\EnrolmentController@editformcandidate');
    Route::post('/enrolments/editform/candidate/{candid}', 'Nber\EnrolmentController@update');
    Route::post('/enrolments/cropimage', 'Nber\EnrolmentController@cropimage');
    Route::get('/enrolments/generateenrolmentno/{apid}', 'Nber\EnrolmentController@generateenrolmentno');
    Route::get('/enrolments/generateenrolmentno1/{apid}', 'Nber\EnrolmentController@generateenrolmentno1');
    Route::get('/enrolments/enrolmentnumber/showlists/{ayid}', 'Nber\EnrolmentController@showlistsforenrolmentnumber');
    Route::get('/enrolments/download-enrolment-verification-details/{ayid}', 'Nber\EnrolmentController@downloadEnrolmentVerificationDetails');
    Route::get('/enrolments/delete/candidate/{cand_id}', 'Nber\EnrolmentController@deletecandidate');
    Route::get('/nber/enrolments/candidate-data/verification-status/{ayid}', 'Nber\EnrolmentController@candidateDataVerificationStatus');
    Route::get('/nber/enrolments/candidate-data/approvedprogramme-list/{ayid}/{statusid}', 'Nber\EnrolmentController@candidateDataVerificationApprovedprogrammeLists');

    Route::get('/nber/provisionalcertificate/', 'Nber\ProvisionalCertificateController@index');
    Route::post('/provisionalcertificate/add-candidate/', 'Nber\ProvisionalCertificateController@addCandidate');
    Route::get('/nber/provisionalcertificate/download/{id}', 'Nber\ProvisionalCertificateController@download');

    Route::get('/nber/examtimetables/', 'Nber\ExamtimetableController@showexams');
    Route::get('/nber/examtimetables/{e_id}/', 'Nber\ExamtimetableController@showexamtimetables');

    /* NBER Question Papers */
    Route::get('/nber/examquestionpapers/{e_id}', 'Nber\QuestionpaperController@showDetails');
    Route::get('/nber/examquestionpapers/{e_id}/{et_id}', 'Nber\QuestionpaperController@updateDetails');
    Route::post('/nber/examquestionpapers/update', 'Nber\QuestionpaperController@updateQuestionPaperDetails');

    Route::get('/nber/evaluations/', 'Nber\EvaluationController@index');
    Route::get('/nber/evaluations/examinationcenterlists/{eid}', 'Nber\EvaluationController@examinationcenterlists');
    Route::get('/nber/evaluations/evaluationcenterlists/{eid}', 'Nber\EvaluationController@evaluationcenterlists');
    Route::get('/nber/evaluations/evaluationcenter/bundles/{eid}/{evcid}', 'Nber\EvaluationController@evaluationcentershowbundles');
    Route::get('/nber/evaluations/evaluationcenter/viewfoilsheets/{eid}/{evcid}/{bno}', 'Nber\EvaluationController@evaluationcenterviewfoilsheets');
    Route::get('/nber/evaluations/evaluationcenter/editfoilsheetform/{eid}/{evcid}/{bno}', 'Nber\EvaluationController@evaluationcenterviewfoilsheets');
    Route::get('/nber/evaluations/bundles/', 'Nber\EvaluationController@showexambundles');
    Route::get('/nber/evaluations/bundles/{exam_id}', 'Nber\EvaluationController@listexambundles');
    Route::get('/nber/evaluations/bundles/{exam_id}/{bundle_number}', 'Nber\EvaluationController@printfoilsheet');
    Route::get('/nber/evaluations/bundles/showmarks/{exam_id}/{bundle_number}', 'Nber\EvaluationController@showmarks');
    Route::get('/nber/evaluations/bundles/updatemarks/{exam_id}/{bundle_number}', 'Nber\EvaluationController@updatemarks');
    Route::post('/nber/evaluations/bundles/updatemarksdata/', 'Nber\EvaluationController@updatemarksdata');
    Route::get('/nber/evaluations/show-generate-dummy-number-page', 'Nber\EvaluationController@showgeneratepage');
    Route::post('/nber/evaluations/generate-barcode', 'Nber\EvaluationController@generatebarcode');

    /*-- NBER Examinations --*/
    Route::get('/nber/examinations/', 'Nber\ExaminationController@index');

    /*-- ./NBER Examinations --*/

    /*-- NBER Registration --*/
    Route::get('/nber/registrations/', 'Nber\RegistrationController@index');
    /*-- ./NBER Registration --*/

    /*-- NBER Registration --*/
    Route::get('/nber/notifications/institute-information/show-institute-lists/', 'Nber\InstituteController@showInstituteLists');
    Route::get('/nber/notifications/institute-information/show-institute/{institute_id}', 'Nber\InstituteController@showCentreInformation');
    Route::post('/nber/notifications/institute-information/update', 'Nber\InstituteController@updateCentreInformation');
    Route::get('/nber/notifications/institute-information/loadData', 'Nber\InstituteController@loadData');
    Route::get('/nber/notifications/institute-information/show/{inst_id}', 'Nber\InstituteController@showInstituteInformation');
    Route::post('/nber/notifications/institute-information/getInstituteInformation', 'Nber\InstituteController@getInstituteInformation');
    Route::post('/nber/notifications/institute-information/updateStatus', 'Nber\InstituteController@updateStatus');

    /*-- ./NBER Registration --*/

    /*-- NBER Registration --*/
    Route::get('/nber/institute/profile/{inst_id}', 'Nber\InstituteInformationController@instituteProfile');
    Route::post('/nber/institute/update-profile', 'Nber\InstituteInformationController@updateProfile');
    /*-- ./NBER Registration --*/

    /*-- NBER Practical Exams */
    Route::get('/nber/practicalexams/{eid}', 'Nber\PracticalexamController@home');
    Route::get('/nber/practicalexams/examiners/{eid}', 'Nber\PracticalexamController@showinstituteslist');
    Route::get('/nber/practicalexams/examiners/courseslist/{eid}/{iid}', 'Nber\PracticalexamController@showcourseslist');
    Route::get('/nber/practicalexams/examiners/showdetails/{eid}/{pid}', 'Nber\PracticalexamController@showdetails');
    Route::get('/nber/practicalexams/examiners/addexternalexaminerdetailsform/{eid}/{pid}', 'Nber\PracticalexamController@addexternalexaminerdetailsform');
    Route::post('/nber/practicalexams/examiners/addexternalexaminerdetails', 'Nber\PracticalexamController@addexternalexaminerdetails');
    Route::post('/nber/practicalexams/examiners/updatepracticalexam', 'Nber\PracticalexamController@updatepracticalexam');
    Route::get('/nber/practicalexams/examiners/updatedetails', 'Nber\PracticalexamController@updatedetails');
    Route::get('/nber/practicalexams/examiners/updatexaminerdetails/{eid}/{practicalexaminer_id}', 'Nber\PracticalexamController@updatexaminerdetails');
    Route::post('/nber/practicalexams/examiners/updatepracticalexaminer', 'Nber\PracticalexamController@updatepracticalexaminer');
    Route::post('/nber/practicalexams/examiners/ajaxrequest/sendemailtoexaminer/', 'Nber\PracticalexamController@sendemailtoexaminer');
    Route::post('/nber/practicalexams/examiners/ajaxrequest/sendemailtoinstitute/', 'Nber\PracticalexamController@sendemailtoinstitute');
    Route::post('/nber/practicalexams/examiners/ajaxrequest/sendemailtoinstitute/', 'Nber\PracticalexamController@sendemailtoinstitute');
    /*-- ./NBER Practical Exams */

    /*-- NBER Theory Exams */
    Route::get('/nber/theoryexams/{eid}', 'Nber\TheoryexamController@index');
    Route::get('/nber/theoryexams/examcenters/{eid}', 'Nber\TheoryexamController@showExamCenters');
    Route::get('/nber/theoryexams/examcenters/add/{eid}', 'Nber\TheoryexamController@addExamCenter');
    Route::post('/nber/theoryexams/examcenters/addexamcenterdetails', 'Nber\TheoryexamController@addExamCenterDetails');
    Route::get('/nber/theoryexams/examcenters/edit/{eid}/{ec_id}', 'Nber\TheoryexamController@editExamCenter');
    Route::post('/nber/theoryexams/examcenters/editexamcenterdetails', 'Nber\TheoryexamController@editExamCenterDetails');
    Route::get('/nber/theoryexams/examcenters/ajaxrequest/checkexamcentercode', 'Nber\TheoryexamController@checkexamcentercode');
    Route::get('/nber/theoryexams/examcenters/institutelists/{eid}', 'Nber\TheoryexamController@instituteslists');

    /*-- ./NBER Theory Exams */

    /*-- NBER Theory Exams - Exam Attendance */
    Route::get('/nber/theoryexams/examattendances/{eid}/{ec_id}', 'Nber\ExamattendanceController@showExamSchedules');
    Route::get('/nber/theoryexams/examattendances/{eid}/{ec_id}/{et_id}', 'Nber\ExamattendanceController@showLists');
    Route::get('/nber/theoryexams/examattendances/showupdateform/{eid}/{ec_id}/{et_id}/{ap_id}', 'Nber\ExamattendanceController@showUpdateForm');
    Route::post('/nber/theoryexams/examattendances/updateattendanceform/', 'Nber\ExamattendanceController@updateAttendanceDetail');
    Route::get('/nber/theoryexams/examattendances/showattendances/{eid}/{ec_id}/{et_id}/{ap_id}', 'Nber\ExamattendanceController@showAttendances');
    /*-- ./NBER Theory Exams - Exam Attendance */


    /*-- NBER Theory Exams - CLO */
    Route::get('/nber/theoryexams/clo/{eid}', 'Nber\CloController@index');
    Route::get('/nber/theoryexams/clo/addclo/{eid}', 'Nber\CloController@addclo');
    Route::post('/nber/theoryexams/clo/addclodetails', 'Nber\CloController@addclodetails');
    Route::get('/nber/theoryexams/clo/updateclo/{eid}/{cloid}', 'Nber\CloController@updateclo');
    Route::post('/nber/theoryexams/clo/updateclodetails', 'Nber\CloController@updateclodetails');
    Route::post('/nber/theoryexams/clo/ajaxrequest/sendemailtoclo/', 'Nber\CloController@sendemailtoclo');
    /*-- ./NBER Theory Exams - CLO */

    /*-- NBER Theory Exams - CS */
    Route::get('/nber/theoryexams/cs/{eid}', 'Nber\CentersuperintendentController@index');
    Route::get('/nber/theoryexams/cs/addcs/{eid}', 'Nber\CentersuperintendentController@addcs');
    Route::post('/nber/theoryexams/cs/addcsdetails', 'Nber\CentersuperintendentController@addcsdetails');
    Route::get('/nber/theoryexams/cs/updatecs/{eid}/{csid}', 'Nber\CentersuperintendentController@updatecs');
    Route::post('/nber/theoryexams/cs/updatecsdetails', 'Nber\CentersuperintendentController@updatecsdetails');
    Route::post('/nber/theoryexams/cs/ajaxrequest/sendemailtocs/', 'Nber\CentersuperintendentController@sendemailtocs');
    /*-- ./NBER Theory Exams - CS */

    /*-- NBER Theory Exams - Nodalofficer */
    Route::get('/nber/theoryexams/nodalofficer/{eid}', 'Nber\NodalofficerController@index');
    /*-- ./NBER Theory Exams - Nodalofficer */

    /*-- NBER Correction Request Tracking --*/
    Route::get('/nber/tracking/documentcorrection/', 'Nber\CorrectionrequesttrackingController@index');
    Route::get('/nber/tracking/documentcorrection/add/', 'Nber\CorrectionrequesttrackingController@add');
    Route::post('/nber/tracking/documentcorrection/adddetails/', 'Nber\CorrectionrequesttrackingController@adddetails');
    Route::get('/nber/tracking/documentcorrection/viewstatus/{cr_id}', 'Nber\CorrectionrequesttrackingController@viewstatus');
    Route::post('/nber/tracking/documentcorrection/updatestatus', 'Nber\CorrectionrequesttrackingController@updatestatus');
    Route::post('/nber/tracking/documentcorrection/updatedetails/', 'Nber\CorrectionrequesttrackingController@updatedetails');
    Route::post('/nber/tracking/ajaxrequest/getcandidatedetails', 'Nber\CorrectionrequesttrackingController@getcandidatedetails');

    /*-- ./NBER Correction Request Tracking --*/

    /*-- NBER Theory Exams - Exam Center Mapping --*/
    Route::get('/nber/theoryexams/examcentermapping/{e_id}', 'Nber\ExamcentermappingController@showExamCenters');
    Route::get('/nber/theoryexams/examcentermapping/updateinstitutemappingform/{e_id}', 'Nber\ExamcentermappingController@updateInstituteMappingForm');
    Route::post('/nber/theoryexams/examcentermapping/updateinstitutemappingdetails/', 'Nber\ExamcentermappingController@updateInstituteMappingDetails');
    Route::get('/nber/theoryexams/examcentermapping/showmappedinstitutes/{e_id}', 'Nber\ExamcentermappingController@showMappedInstitutes');
    Route::get('/nber/theoryexams/examcentermapping/downloadmappedinstitutes/{e_id}', 'Nber\ExamcentermappingController@downloadMappedInstitutes');
    Route::get('/nber/theoryexams/examcentermapping/examcenterdetails/{e_id}/{exc_id}', 'Nber\ExamcentermappingController@examCenterDetails');
    Route::post('/nber/theoryexams/examcentermapping/ajarequest/updatedexamcenter/', 'Nber\ExamcentermappingController@ajaxUpdateExamCenter');
    /*-- ./NBER Theory Exams - Exam Center Mapping --*/

    /*-- NBER Staff --*/
    Route::get('/nber/staffs','Nber\NberStaffController@index');
    Route::get('/staffs/create','Nber\NberStaffController@create');
    Route::get('/staffs/update','Nber\NberStaffController@update');
    Route::post('/updatepassword/{id}','Nber\NberStaffController@changepassword');
    Route::post('/nber/staff/ajaxrequest/sendmobilenumberverificationcode','Nber\NberStaffController@sendMobileNumberVerificationCode');
    Route::post('/nber/staff/create-staff-profile','Nber\NberStaffController@createStaff')->name('create.staff.profile');
});

Route::group(array('middleware' => ['student']), function (){
	Route::get('/downloadhallticket','Student\HallticketController@index');
	Route::get('/profile','Student\CandidateController@index');
	Route::get('/hallticketdownload','Student\HallticketController@download');
	Route::get('/examtimetable','Student\HallticketController@timetable');
});
/*
Route::group(array('middleware' => ['clo']), function ()
{
	Route::get('clo',function(){return view('clo.welcome');});
	Route::get('cloqp/{exam_id}','Clo\ExamController@qpdownloads');
	Route::get('/clo/downloadfile/questionpaper/{et_id}','Clo\ExamController@qpdownload');
	Route::get('/uploadcloreport/{et_id}','Clo\ExamController@uploadreports');
	Route::get('/clo/timetable','Clo\ExamController@timetable');
	Route::post('/clo/upload/report/{examtimetable_id}/{clorreportfile_id}','Clo\ExamController@uploadreport');

	Route::get('/malpractices','Clo\MalpracticeController@index');
	Route::get('/malpractices/create','Clo\MalpracticeController@create');
	Route::get('/malpractices/update','Clo\MalpracticeController@update');
	Route::post('/clo/upload/malpractice/file/{malpractice_id}','Clo\MalpracticeController@uploadfile');

});
*/

Route::group(array('middleware' => ['baslp']), function (){
    Route::get('/baslp-exam/{exam_id}/hallticket/','Baslp\HomeController@show_hallticket_page');
    Route::post('/baslp-exam/hallticket/','Baslp\HomeController@check_roll_no');
    Route::get('/baslp-exam/download-candidate-hallticket/{exd_id}','Nber\BaslpController@download_candidate_hallticket');
});

Route::group(array('middleware' => ['evaluationcenteruser']), function (){
    //Route::get('/evaluationcenter/', 'Evaluationcenter\HomeController@index');
});