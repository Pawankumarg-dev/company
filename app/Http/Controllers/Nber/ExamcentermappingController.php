<?php

namespace App\Http\Controllers\Nber;

use App\Application;
use App\Approvedprogramme;
use App\Exam;
use App\Examcenter;
use App\Externalexamcenter;
use App\Http\Controllers\Externalexamcenter\AttendanceController;
use App\Institute;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class ExamcentermappingController extends Controller
{
    //
    public function __construct()
    {
       $this->middleware(['role:nber']);
    }

    public function index() {

    }

    public function showExamCenters($eid) {
        $exam = Exam::find($eid);

        if(!is_null($exam)) {
            /*
            $examcenters = Externalexamcenter::whereHas('applications', function($query) use($exam) {
              $query->where('exam_id', $exam->id)->select('examid');
            })->get(['id', 'code', 'name', 'state']);
            */

            $examcenterIds = Application::where('exam_id', $exam->id)->groupBy('externalexamcenter_id')->pluck('externalexamcenter_id')->toArray();

            $examcenters = Externalexamcenter::whereIn('id', $examcenterIds)->orderBy('code')->get(['id', 'code', 'password', 'name', 'state']);

            unset($examcenterIds);

            return view('nber.theoryexams.examcentermappings.show_exam_centers', compact('exam', 'examcenters'));
        }
        else {
            unset($exam);
            return redirect('/nber/exams');
        }
    }

    public function updateInstituteMappingForm($eid) {
        $exam = Exam::find($eid);

        if(!is_null($exam)) {
            $examcenters = Externalexamcenter::where('active_status', 1)->orderBy('code')->get(['id', 'code']);

            $institutes = Institute::
                join('approvedprogrammes', 'approvedprogrammes.institute_id', '=', 'institutes.id')
                ->join('applications', 'applications.approvedprogramme_id', '=', 'approvedprogrammes.id')
                ->join('subjects', 'subjects.id', '=', 'applications.subject_id')
                ->where('applications.exam_id', $exam->id)
                ->where('subjects.subjecttype_id', 1)
                ->groupBy('approvedprogrammes.institute_id')
                ->orderBy('institutes.code')
                ->get(['institutes.id', 'institutes.code']);

            return view('nber.theoryexams.examcentermappings.update_institute_mapping_form', compact('exam', 'examcenters', 'institutes'));
        }
        else {
            unset($exam);
            return redirect('/nber/exams');
        }
    }

    public function updateInstituteMappingDetails(Request $request) {
        Application::where('exam_id', $request->examId)
            ->whereIn('approvedprogramme_id', Approvedprogramme::where('institute_id', $request->instituteId)->pluck('id')->toArray())
            ->whereHas('subject', function($query){
                $query->where('subjecttype_id', 1);
            })
            ->update([
                "externalexamcenter_id" => $request->examcenterId,
                "hallticket_status" => 1
            ]);

        return redirect('/nber/theoryexams/examcentermapping/showmappedinstitutes/'.$request->examId)->with(['message' => 'Updated Successfully!!!']);
    }

    public function showMappedInstitutes($eid) {
        $exam = Exam::find($eid);

        if(!is_null($exam)) {
            /*
            $applications = Application::whereHas('subject', function ($query){
                $query->where('subjecttype_id', '1');
            })->where('exam_id', $exam->id)->groupBy('approvedprogramme_id')->groupBy('externalexamcenter_id')
                ->whereHas('approvedprogramme', function ($query) {
                    $query->with('institute');
                })
                ->get(['id', 'approvedprogramme_id'])->sortBy('institute.code');

            foreach ($applications as $app)
                echo $app->approvedprogramme_id.' || Code: '.$app->approvedprogramme->institute->code.'<br>';
            */

            $collections = Institute::join('approvedprogrammes', 'approvedprogrammes.institute_id', '=', 'institutes.id')
                ->join('applications', 'applications.approvedprogramme_id', '=', 'approvedprogrammes.id')
                ->join('externalexamcenters', 'externalexamcenters.id', '=', 'applications.externalexamcenter_id')
                ->where('applications.exam_id', $exam->id)
                ->groupBy('approvedprogrammes.institute_id')
                ->groupBy('applications.externalexamcenter_id')
                ->orderBy('institutes.code')
                ->get(['institutes.id as instituteID', 'institutes.code as instituteCode', 'institutes.name as instituteName', 'externalexamcenters.id as examcenterId', 'externalexamcenters.code as examcenterCode']);


            $examcenters = Externalexamcenter::where('active_status', 1)->orderBy('code')->get(['id', 'code']);

            return view('nber.theoryexams.examcentermappings.show_mapped_institutes', compact('exam', 'collections', 'examcenters'));
        }
        else {
            unset($exam);
            return redirect('/nber/exams');
        }
    }

    public function ajaxUpdateExamCenter(Request $request) {
        Application::where('exam_id', $request->examId)
            ->whereIn('approvedprogramme_id', Approvedprogramme::where('institute_id', $request->instituteId)->pluck('id')->toArray())
            ->update([
                'externalexamcenter_id' => $request->examcenterId
            ]);

        $responseData = "/nber/theoryexams/examcentermapping/showmappedinstitutes/".$request->examId;

        return response()->json($responseData);
    }

    public function downloadMappedInstitutes($eid) {
        $exam = Exam::find($eid);

        if(!is_null($exam)) {
            $collections = Institute::join('approvedprogrammes', 'approvedprogrammes.institute_id', '=', 'institutes.id')
                ->join('applications', 'applications.approvedprogramme_id', '=', 'approvedprogrammes.id')
                ->join('externalexamcenters', 'externalexamcenters.id', '=', 'applications.externalexamcenter_id')
                ->where('applications.exam_id', $exam->id)
                ->where('applications.externalexamcenter_id', '!=', 0)
                ->groupBy('approvedprogrammes.institute_id')
                ->groupBy('applications.externalexamcenter_id')
                ->orderBy('institutes.code')
                ->get(['institutes.id as instituteID', 'institutes.code as instituteCode', 'institutes.name as instituteName', 'externalexamcenters.code as externalexamcenterCode', 'externalexamcenters.name as externalexamcenterName']);

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            $sheet->setCellValue('A1', 'S.No');
            $sheet->setCellValue('B1', 'Institute Code');
            $sheet->setCellValue('C1', 'Institute Name');
            $sheet->setCellValue('D1', 'Exam Centre Code');
            $sheet->setCellValue('E1', 'Exam Centre Name');

            if($collections->count() > 0) {
                $rowCount = 2;
                $sno = 1;
                foreach ($collections as $collection) {
                    $sheet->setCellValue('A'.$rowCount, $sno);
                    $sheet->setCellValue('B'.$rowCount, $collection->instituteCode);
                    $sheet->setCellValue('C'.$rowCount, $collection->instituteName);
                    $sheet->setCellValue('D'.$rowCount, $collection->externalexamcenterCode);
                    $sheet->setCellValue('E'.$rowCount, $collection->externalexamcenterName);
                    $rowCount++;
                    $sno++;
                }
            }

            $filename = $exam->name.' Examinations - Institute Mapped.xlsx';
            ob_end_clean();
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="'.$filename.'"');
            header('Cache-Control: max-age=0');

            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save('php://output');
        }
        else {
            unset($exam);
            return redirect('/nber/exams');
        }
    }

    public function examCenterDetails($eid, $excid) {
        $exam = Exam::find($eid);

        if(!is_null($exam)) {
            $examcenter = Externalexamcenter::find($excid);

            if(!is_null($examcenter)) {
                if(Application::where('externalexamcenter_id', $examcenter->id)->where('exam_id', $exam->id)->exists()) {
                    $collections = Institute::join('approvedprogrammes', 'approvedprogrammes.institute_id', '=', 'institutes.id')
                        ->join('applications', 'applications.approvedprogramme_id', '=', 'approvedprogrammes.id')
                        ->where('applications.exam_id', $exam->id)
                        ->where('applications.externalexamcenter_id', $examcenter->id)
                        ->groupBy('approvedprogrammes.institute_id')
                        ->groupBy('applications.externalexamcenter_id')
                        ->orderBy('institutes.code')
                        ->get(['institutes.id as instituteID', 'institutes.code as instituteCode', 'institutes.name as instituteName']);


                    return view('/nber.theoryexams.examcentermappings.exam_center_details', compact('exam', 'examcenter', 'collections'));
                }
                else {
                    unset($examcenter);
                    return redirect('/nber/theoryexams/examcentermapping/'.$exam->id);
                }
            }
            else {
                unset($examcenter);
                return redirect('/nber/theoryexams/examcentermapping/'.$exam->id);
            }
        }
        else {
            unset($exam);
            return redirect('/nber/exams');
        }
    }
}
