<?php

namespace App\Data\Documents;

use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
class EduSertificateIndexFormData extends Data
{
    public string $docType;
    public Carbon $documentDate;
    public UploadedFile$file;
}
