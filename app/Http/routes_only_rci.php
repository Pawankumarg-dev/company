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
{});

/*Route::group(array('middleware' => ['nber']), function ()
{});


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


Route::group(array('middleware' => ['baslp']), function (){
    Route::get('/baslp-exam/{exam_id}/hallticket/','Baslp\HomeController@show_hallticket_page');
    Route::post('/baslp-exam/hallticket/','Baslp\HomeController@check_roll_no');
    Route::get('/baslp-exam/download-candidate-hallticket/{exd_id}','Nber\BaslpController@download_candidate_hallticket');
});

Route::group(array('middleware' => ['evaluationcenteruser']), function (){
    //Route::get('/evaluationcenter/', 'Evaluationcenter\HomeController@index');
});*/
