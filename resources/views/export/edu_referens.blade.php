<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
    <style>
         body { font-family: times_new; }
         .bold{
            font-weight: bold;
         }
         p {
            margin:0;
            font-size: 14pt;
            line-height:1;
         }
         .text-center{
            text-align: center;
         }
         .fz-14{
            font-size: 14pt;
         }
         .fz-12{
            font-size: 12pt;
         }
         .fz-11{
            font-size: 11pt;
         }
         .mt-2{
            margin-top:25px;
         }
    </style>
  </head>
  <body>
    @php
        $a = 0; // счетчик справок
    @endphp
    @foreach ($students as $student)
        @php
            $a++;
        @endphp
        {{-- @dd($student) --}}
        <p class="text-center fz-12 lh-1">МИНИСТЕРСТВО ОБРАЗОВАНИЯ И НАУКИ АЛТАЙСКОГО КРАЯ</p>
        <p class="text-center fz-12 lh-1">краевое государственное бюджетное профессиональное образовательное учреждение <br> «Барнаульский государственный педагогический колледж имени Василия Константиновича Штильке» (КГБПОУ «БГПК имени В.К. Штильке»)</p>
        <p class="text-center fz-11 lh-1">80-й Гвардейской Дивизии ул., д. 41, Барнаул, 656010, телефон: (3852) 33-61-00, <br> факс: (3852) 55-56-21, E-mail: bgpk@22edu.ru</p>
        <p class="text-center fz-12 mt-2 bold lh-1">СПРАВКА</p>
        <p style="float:left">{{ $documetn_date->isoFormat('« D » MMMM YYYY', 'Do MMMM'); }}</p>
        <p style="float:right">№_____________</p>
        <br>
        <p><u>{{ $student->get_fio() }}</u>, {{ $student->get_date()->isoFormat('« D » MMMM YYYY', 'Do MMMM'); }} года рождения</p>
        <p class="fz-11" style="margin-left:70px">ФИО</p>
        <p>обучается в КГБПОУ «БГПК имени В.К. Штильке» по основной образовательной программе <u> {{ $student->get_program() }}</u></p>
        <p class="fz-11" style="margin-left:170px">наиминование программы</p>
        <p>{{ $student->get_spec() }} и является студентом {{ $student->get_course() }} курса {{ $student->get_group() }} группы.</p>

        <p>Форма обучения: @if($student->get_form_edu() == 'Очная')<u>очная</u> @else очная @endif, @if($student->get_form_edu() == 'Заочная')<u>заочная</u> @else заочная @endif ( @if ($student->get_form_pay() == 'Бюджет') <u>бюджет</u> @else бюджет @endif/@if ($student->get_form_pay() == 'Платно') <u>платно по договору</u> @else платно по договору @endif).</p>
        <p>Срок обучения с {{ $student->get_date_edu_start()->format('« d » m Y') }} г. по {{ $student->get_date_edu_end()->format('« d » m Y') }} г., зачислен(а) приказом  от {{ $student->get_order_date()->format('« d » m Y') }} г. №{{ $student->get_order_num() }}.<br> </p>
        <p>Справка выдана для предоставления по месту требования.</p>
        <br>
        <p style="float:left">Директор</p>
        <p style="float:right">Самолетов М. Б.</p>
        <br><br> 
        @if ($a%2 != 0) <hr style="margin-top:30px"> @elseif($a != count($students)) <div style="page-break-before: always;"></div> @endif    
    @endforeach
  </body>
</html>