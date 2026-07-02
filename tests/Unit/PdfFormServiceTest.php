<?php

namespace Tests\Unit;

use App\Service\PdfFormService;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class PdfFormServiceTest extends TestCase
{
    public function test_merge_accepts_uploaded_files_and_returns_a_pdf_path(): void
    {
        $pdfPath = storage_path('app/templates/insuranceLaw.pdf');
        $this->assertFileExists($pdfPath);

        $uploadedFile = UploadedFile::fake()->createWithContent(
            'insurance.pdf',
            file_get_contents($pdfPath),
            'application/pdf'
        );

        $outputPath = (new PdfFormService())->merge([$uploadedFile]);

        $this->assertFileExists($outputPath);
        $this->assertStringEndsWith('.pdf', basename($outputPath));

        @unlink($outputPath);
    }
}
