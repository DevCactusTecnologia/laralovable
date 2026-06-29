<?php

namespace App\Http\Controllers\Routine;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Routine\ProductionExamService;

final class ProductionExamController extends Controller
{
    public function __construct(
        private readonly ProductionExamService $service
    ) {}

    public function index()
    {
        return view('routine.production-by-exam.index');
    }

    public function searchAll(Request $request)
    {
        return response()->json([
            'exams' => $this->service->getAll(
                $request->date_start, 
                $request->date_end,
            )
        ]);
    }

    public function print(string $dateStart, string $dateEnd, Request $request)
    {   
        return view('routine.production-by-exam.print',[
            'exams' => $this->service->getPayload(
                startedAt: $dateStart,
                finishedAt: $dateEnd,
                examsIds: $request->exams_ids,
            )
        ]);
    }
}
