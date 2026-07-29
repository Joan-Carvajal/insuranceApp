<?php

namespace App\Service;


use iio\libmergepdf\Merger;
use Illuminate\Support\Facades\Log;
use setasign\Fpdi\Tcpdf\Fpdi;
use Illuminate\Support\Str;
use Symfony\Component\Process\Process;
use TCPDF_FONTS;

class PdfFormService
{



  public function merge(array $files): string
{
    $merger = new Merger();

    foreach ($files as $file) {

        if (!$file || !file_exists($file)) {
            continue;
        }

        $merger->addFile($file);
    }

    $output = tempnam(
        sys_get_temp_dir(),
        'merged_pdf_'
    );

    file_put_contents(
        $output,
        $merger->merge()
    );

    return $output;
}
public function mergePy(array $files): string
{
    $files = array_values(array_filter($files, fn($f) => $f && file_exists($f)));

    if (empty($files)) {
        throw new \RuntimeException('No hay archivos válidos para unir.');
    }

    $output = tempnam(sys_get_temp_dir(), 'merged_pdf_') . '.pdf';

    $process = new Process([
        'python3',
        base_path('scripts/merge_pdf.py'),
        ...$files,
        $output,
    ]);
    $process->setTimeout(200);
    $process->run();

    if (!$process->isSuccessful()) {
        Log::error('Merge PDF falló', ['error' => $process->getErrorOutput()]);
        throw new \RuntimeException('No se pudo unir los PDFs.');
    }

    return $output;
}

    public function generate(array $data, string $fileName)
    {
        $fontPath = storage_path('fonts/Dancing_Script/static/DancingScript-Regular.ttf');
        $signatureFont = file_exists($fontPath)
            ? TCPDF_FONTS::addTTFfont($fontPath, 'TrueTypeUnicode', '', 32)
            : false;

        // IMPORTANTE: usar puntos (pt)
        $pdf = new Fpdi('P', 'pt');

        $pdf->SetAutoPageBreak(false);

        $templatePath = storage_path(
            'app/templates/insuranceLawNew.pdf'
        );

        $data['signature'] = Str::title($data['signature']);
        $pageCount = $pdf->setSourceFile($templatePath);

        $fields = $this->fieldMap();

        for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {

            $template = $pdf->importPage($pageNo);

            $size = $pdf->getTemplateSize($template);

            $pdf->AddPage(
                $size['orientation'],
                [$size['width'], $size['height']]
            );

            $pdf->useTemplate($template);

            $pdf->SetFont('helvetica', '', 10);
            $pdf->SetTextColor(0, 0, 0);

            foreach ($fields as $field => $locations) {

                if (!array_key_exists($field, $data)) {
                    continue;
                }

                $fontName = 'helvetica';
                $fontSize = 10;

                if ($field === 'signature') {
                    $fontName = $signatureFont ?: 'helvetica';
                    $fontSize = 11;
                }

                $pdf->SetFont($fontName, '', $fontSize);

                foreach ($locations as $location) {

                    if ($location['page'] !== $pageNo) {
                        continue;
                    }

                    $pdf->Text(
                        $location['x'],
                        $location['y'],
                        (string) $data[$field]
                    );
                }
            }
        }

        $output = rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR)
            . DIRECTORY_SEPARATOR
            . basename($fileName);

        $pdf->Output($output, 'F');

        return $output;
    }

    private function fieldMap(): array
    {
        return [

            'patient_name' => [
                ['page' => 1, 'x' => 84,  'y' => 202],
                ['page' => 1, 'x' => 47,  'y' => 492],
                ['page' => 2, 'x' => 136, 'y' => 217],
                ['page' => 3, 'x' => 55,  'y' => 140],
                ['page' => 3, 'x' => 105, 'y' => 692],
            ],

            'diagnostic_type' => [
                ['page' => 1, 'x' => 403, 'y' => 201],
                ['page' => 1, 'x' => 115, 'y' => 648],
            ],

            'date_of_accident' => [
                ['page' => 1, 'x' => 155, 'y' => 292],
                ['page' => 2, 'x' => 70,  'y' => 235],
            ],

            'signature' => [
                ['page' => 1, 'x' => 370, 'y' => 477],
            ],

            'date_of_signature' => [
                ['page' => 1, 'x' => 385, 'y' => 516],
                ['page' => 1, 'x' => 395, 'y' => 607],
                ['page' => 3, 'x' => 422, 'y' => 693],
            ],

            'address' => [
                ['page' => 1, 'x' => 41,  'y' => 560],
                ['page' => 2, 'x' => 348, 'y' => 260],
                ['page' => 3, 'x' => 130, 'y' => 160],
            ],

            'date_of_birth' => [
                ['page' => 2, 'x' => 168, 'y' => 238],
                ['page' => 3, 'x' => 272, 'y' => 130],
            ],

            'phone' => [
                ['page' => 2, 'x' => 322, 'y' => 244],
            ],

            'claim' => [
                ['page' => 2, 'x' => 82, 'y' => 282],
            ],

            'insurance_company' => [
                ['page' => 2, 'x' => 250, 'y' => 289],
            ],
        ];
    }
}
