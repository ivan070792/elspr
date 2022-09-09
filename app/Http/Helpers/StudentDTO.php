<?php

namespace App\Http\Helpers;

use Carbon\Carbon;

class StudentDTO{

    private string $fio;
    public Carbon $date;
    public string $program;
    public string $spec;
    public int $course;
    public int $group;
    public string $form_edu;
    public string $form_pay;
    public Carbon $date_edu_start;
    public Carbon $date_edu_end;
    public Carbon $order_date;
    public string $order_num;

    function __construct(string $fio, Carbon $date, string $program, string $spec, int $course, int $group, string $form_edu, string $form_pay, Carbon $date_edu_start, Carbon $date_edu_end, Carbon $order_date, string $order_num, int $amount){
        $this->fio = $fio;
        $this->date = $date;
        $this->program = $program;
        $this->spec = $spec;
        $this->cource = $course;
        $this->group = $group;
        $this->form_edu = $form_edu;
        $this->form_pay = $form_pay;
        $this->date_edu_start = $date_edu_start;
        $this->date_edu_end = $date_edu_end;
        $this->order_date = $order_date;
        $this->order_num = $order_num;
        $this->amount = $amount;

    }

    public function get_fio(){
        return $this->fio;
    }
    public function get_date(){
        return $this->date;
    }
    public function get_program(){
        return $this->program;
    }
    public function get_spec(){
        return $this->spec;
    }
    public function get_course(){
        return $this->cource;
    }
    public function get_group(){
        return $this->group;
    }
    public function get_form_edu(){
        return $this->form_edu;
    }
    public function get_form_pay(){
        return $this->form_pay;
    }
    public function get_date_edu_start(){
        return $this->date_edu_start;
    }
    public function get_date_edu_end(){
        return $this->date_edu_end;
    }
    public function get_order_date(){
        return $this->order_date;
    }
    public function get_order_num(){
        return $this->order_num;
    }
    public function get_amount(){
        return $this->amount;
    }
}