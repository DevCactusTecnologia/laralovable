<?php

namespace App\Services\Routine;

use Illuminate\Support\Facades\DB;

final class ProductionExamService
{
    public static function getAll(string $startedAt, string $finishedAt): array
    {
        $payload = [];
        $exams = DB::select(
            "SELECT
                exams.id,
                exams.name
            FROM appointment_exams
            INNER JOIN exams
            ON appointment_exams.exam_id = exams.id  
            WHERE appointment_exams.collected_at BETWEEN ? AND ?
            AND appointment_exams.status = 1 
            GROUP BY exams.id, exams.name", 
            [$startedAt, $finishedAt]
        );

        foreach ($exams as $exam) {
            $payload[] = [
                'id' => $exam->id,
                'name' => $exam->name,
            ];
        }

        return $payload;
    }

    public static function getPayload(string $startedAt, string $finishedAt, string $examsIds): array
    {
        $payload = [];
        $examsIds = explode('|', $examsIds);
        $placeholders = implode(',', array_fill(0, count($examsIds), '?'));
        $registers = DB::select(
            "SELECT
                exams.id AS exam_id,
                exams.name AS exam_name,
                users.first_name AS patient_name,
                appointment_exams.collected_at,
                appointments.created_at
            FROM appointment_exams
            INNER JOIN exams
            ON appointment_exams.exam_id = exams.id  
            INNER JOIN appointments
            ON appointment_exams.appointment_id = appointments.id
            INNER JOIN users
            ON appointments.appointment_for = users.id
            WHERE appointment_exams.collected_at BETWEEN ? AND ?
            AND appointment_exams.status = 1 AND exams.id IN ({$placeholders})",
            [$startedAt, $finishedAt, ...$examsIds]
        );


        if (count($registers) <= 0) {
            return [];
        }

        foreach ($registers as $register) {
            $payload[$register->exam_name][] = (object) [
                'patient' => $register->patient_name,
                'registered_at' => date('d/m/Y', strtotime($register->created_at)) . ' ' . explode(' ', $register->created_at)[1],
            ];
        }

        return $payload;
    }
}
