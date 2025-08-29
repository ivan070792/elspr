<?php

namespace App\Data\Student;

use Carbon\Carbon;
use Spatie\LaravelData\Data;

class StudentData extends Data
{
    public $fullname;
    public Carbon $birthDate;
    public  $program;
    public  $specialty;
    public  $course;
    public  $group;
    public  $formEdu;
    public  $formPay;
    public Carbon $dateStartEdu;
    public Carbon $dateEndEdu;
    public Carbon $orderDate;
    public  $orderNum;
    public  $amount;
}
