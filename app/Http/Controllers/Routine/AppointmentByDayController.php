<?php

namespace App\Http\Controllers\Routine;

use PDF;
use App\Models\Appointment\Appointment;
use App\Models\Exam\Exam;
use App\Models\Unity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Exam\Model;
use App\Models\Patient;
use App\Traits\ResultExam\ConfigPdf;
use App\Traits\ResultExam\ContentPdf;
use App\Traits\ResultExam\FooterPdf;
use App\Traits\ResultExam\HeaderPdf;
use Illuminate\Support\Facades\DB;

class AppointmentByDayController extends Controller
{
    use ConfigPdf, HeaderPdf, FooterPdf, ContentPdf;

    public function index()
    {   
        $unitys = Unity::active()->get();

        return view('routine.appointment-by-day.index', 
            compact('unitys')
        );
    }

    public function search(Request $request)
    {   
        return response()->json([
            'appointments' => Appointment::routineBy($request->date, $request->unity_id)
        ]);
    }

    public function print(string|null $date, int|null $unity_id, string $status)
    {   
        $appointments = Appointment::getTodayData($date, $unity_id, $status);

        $this->config();
        $this->footer(isPaginate: false);

        $contentLong = Exam::listContentLong();

        foreach ($appointments as $index => $appointment) {
            $this->headerAppointmentByDay($appointment);
            PDF::AddPage();

            $counter = 0;
            $examsTotal = count($appointment['exams']);
            $biomedicalSignId = [];
            $biomedicalSignContent = [];
            $patient = Patient::firstWhere('user_id', $appointment['patient_id']);

            foreach ($appointment['exams'] as $key => $exam) {
                $this->addHeaderExamRoutine($exam['object']->name);
                $counter++;

                PDF::SetFont('courier', '', 9);

                $model = DB::select(
                    "SELECT exam_editor FROM exam_models WHERE id = ?", [$exam['model_id']]
                );

                $this->generateContentAppointmentByDay(
                    $appointment, 
                    $patient,
                    $exam['object'], 
                    $model[0]->exam_editor,
                    $exam['biomedical_id'], 
                    $biomedicalSignId,
                    $biomedicalSignContent,
                    $exam['object']->id, 
                    $contentLong,
                    $examsTotal,
                    $key,
                    $counter,
                    $exam['re_test'],
                    $exam['re_test_motive'],
                );
            }
        }

        PDF::Output("impressao-geral-{$date}.pdf", 'I');
    }

}
