<?php

namespace App\Http\Controllers;

use App\service\PdfFormService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ContractController extends Controller
{
    public function generate(Request $request, PdfFormService $pdfFormService)
    {
        $data = $request->validate([
            'patient_name' => ['required', 'string'],
            'diagnostic_type' => ['required', 'string'],
            'date_of_accident' => ['required', 'string'],
            'signature' => ['nullable', 'string'],
            'date_of_signature' => ['required', 'string'],
            'address' => ['required', 'string'],
            'date_of_birth' => ['required', 'string'],
            'phone' => ['required', 'string'],
            'claim' => ['required', 'string'],
            'insurance_company' => ['required', 'string'],
            'cardio_tech' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
            'heart_health' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
        ]);

        if (str_contains($data['patient_name'], ',')) {
            $parts = explode(',', $data['patient_name'], 2);
            $data['patient_name'] = trim($parts[1]) . ' ' . trim($parts[0]);
        }

        $data['patient_name'] = Str::title($data['patient_name']);

        if (empty($data['signature'])) {
            $data['signature'] = $data['patient_name'];
        }

        try {
            $cardioTechFile = $request->file('cardio_tech')?->getRealPath();
            $heartHealthFile = $request->file('heart_health')?->getRealPath();
            $holterFile = $request->file('holter')?->getRealPath();
            $mctFile = $request->file('mct')?->getRealPath();

            $fileName = $data['patient_name'] . '_' . $data['diagnostic_type'] . ' ' . '.pdf';
            $signatureFile = $pdfFormService->generate($data, Str::uuid() . '.pdf');
            $finalPath = $pdfFormService->mergePy([$cardioTechFile, $signatureFile, $holterFile, $mctFile]);

            return response()->download($finalPath, $fileName)->deleteFileAfterSend(true);
        } catch (\Throwable $e) {
            Log::error('Error al generar PDF', [
                'error' => $e->getMessage(),
                'patient' => $data['patient_name'],
            ]);

            return redirect()->back()->with('error', 'Hubo un error al generar el PDF. Por favor, intente de nuevo.');
        }
    }
}
