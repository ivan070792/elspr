<?php

namespace App\Services;

use App\Dto\StudentDTO;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as ReaderXlsx;
use PhpOffice\PhpWord\PhpWord;

class DocumentService
{
    /**
     * @param array $fileData
     *
     * @return array
     * @throws \Exception
     */
    public function getPrepareFileData(array $fileData): array
    {
        $prepareFileData = [];
        foreach ($fileData as $key => $data) {
            try {
                $prepareFileData [] = [
                    'fullname'     => $data[0],
                    'birthDate'    => Carbon::parse($data[1]),
                    'program'      => $data[2],
                    'specialty'    => $data[3],
                    'course'       => $data[4],
                    'group'        => $data[5],
                    'formEdu'      => $data[6],
                    'formPay'      => $data[7],
                    'dateStartEdu' => Carbon::parse($data[8]),
                    'dateEndEdu'   => Carbon::parse($data[9]),
                    'orderDate'    => Carbon::parse($data[10]),
                    'orderNum'     => $data[11],
                    'amount'       => $data[12],
                ];
            } catch (\Exception $e) {
                throw new \Exception('Ошибка в строке ' . $key);
            }
        }
        return $prepareFileData;
    }
}
