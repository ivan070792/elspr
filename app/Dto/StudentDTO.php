<?php

namespace App\Dto;

use Carbon\Carbon;

class StudentDTO{

    function __construct(
        private string $fullname,
        private Carbon $birthDate,
        private string $program,
        private string $specialty,
        private int    $course,
        private string $group,
        private string $formEdu,
        private string $formPay,
        private Carbon $dateStartEdu,
        private Carbon $dateEndEdu,
        private Carbon $orderDate,
        private string $orderNum,
        public int     $amount) {

    }

    public function getFullname(){
        return $this->fullname;
    }
    public function getBirthDate(){
        return $this->birthDate;
    }
    public function getProgram(){
        return $this->program;
    }
    public function getSpecialty(){
        return $this->specialty;
    }
    public function getCourse(){
        return $this->course;
    }
    public function getGroup(){
        return $this->group;
    }
    public function getFormEdu(){
        return $this->formEdu;
    }
    public function getFormPay(){
        return $this->formPay;
    }
    public function getDateStartEdu(){
        return $this->dateStartEdu;
    }
    public function getDateEndEdu(){
        return $this->dateEndEdu;
    }
    public function getOrderDate(){
        return $this->orderDate;
    }
    public function getOrderNum(){
        return $this->orderNum;
    }
    public function getAmount(){
        return $this->amount;
    }
}
