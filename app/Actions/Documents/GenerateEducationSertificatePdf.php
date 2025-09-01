<?php

namespace App\Actions\Documents;

use App\Data\Student\StudentData;
use \Barryvdh\DomPDF\PDF as PDF;
use Carbon\Carbon;

class GenerateEducationSertificatePdf
{

    /**
     * @param iterable<StudentData> $students
     * @param Carbon $documentDate
     *
     * @return PDF
     */
    public function __invoke(iterable $students, Carbon $documentDate): PDF
    {
        return PDF::loadView('export.edu_referens_pdf', ['students' => $students, 'document_date' => $documentDate]);
    }
}
