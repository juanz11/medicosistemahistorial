<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Paciente;
use App\Models\Consulta;
use App\PDF\PDFGenerator;
use Carbon\Carbon;

class WebController extends Controller
{
    public function home()
    {
        return view('home');
    }

    public function crearPaciente()
    {
        return view('pacientes.crear');
    }

    public function guardarPaciente(Request $request)
    {
        $data = $request->validate([
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'cedula' => 'required|string|max:255|unique:pacientes,cedula',
            'edad' => 'required|integer|min:0|max:150',
            'telefono' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
        ]);

        $paciente = new Paciente($data);
        $paciente->user_id = Auth::id();
        $paciente->save();

        return redirect()
            ->route('pacientes.historial', $paciente->id)
            ->with('success', 'Paciente registrado correctamente.');
    }

    public function verPaciente($id)
    {
        $paciente = Paciente::with('user')->findOrFail($id);
        $consultas = $paciente->consulta()->with('user')->orderByDesc('fecha')->orderByDesc('id')->get();

        return view('pacientes.historial', compact('paciente', 'consultas'));
    }

    public function guardarConsulta(Request $request, $id)
    {
        $paciente = Paciente::findOrFail($id);

        $data = $request->validate([
            'fecha' => 'required|date',
            'diagnostico' => 'required|string',
            'tratamiento' => 'nullable|string',
            'observaciones' => 'nullable|string',
            'proxima_cita' => 'nullable|date',
        ]);

        $consulta = new Consulta($data);
        $consulta->paciente_id = $paciente->id;
        $consulta->user_id = Auth::id();
        $consulta->save();

        return redirect()
            ->route('pacientes.historial', $paciente->id)
            ->with('success', 'Diagnóstico registrado correctamente.');
    }

    public function descargarHistorialPdf(Request $request, $id)
    {
        $paciente = Paciente::findOrFail($id);
        $consultas = $paciente->consulta()->with('user')->orderBy('fecha')->orderBy('id')->get();

        $pdf = $this->nuevoPdf();

        if ($consultas->isEmpty()) {
            $this->encabezadoPaciente($pdf, $paciente);
            $pdf->SetFont('Helvetica', '', 11);
            $pdf->MultiCell(0, 7, $this->t('Este paciente aún no tiene diagnósticos registrados.'));
        }

        foreach ($consultas as $consulta) {
            $this->paginaConsulta($pdf, $paciente, $consulta);
        }

        return $this->descargar($pdf, 'historial-' . $paciente->cedula . '.pdf', $request->boolean('ver'));
    }

    public function descargarConsultaPdf(Request $request, $id)
    {
        $consulta = Consulta::with('paciente', 'user')->findOrFail($id);

        $pdf = $this->nuevoPdf();
        $this->paginaConsulta($pdf, $consulta->paciente, $consulta);

        return $this->descargar($pdf, 'consulta-' . $consulta->id . '.pdf', $request->boolean('ver'));
    }

    private function nuevoPdf()
    {
        $pdf = new PDFGenerator();
        $pdf->SetAutoPageBreak(true, 20);
        $pdf->SetMargins(15, 15, 15);
        return $pdf;
    }

    private function paginaConsulta(PDFGenerator $pdf, Paciente $paciente, Consulta $consulta)
    {
        $this->encabezadoPaciente($pdf, $paciente);

        $pdf->SetFont('Helvetica', 'B', 13);
        $pdf->Cell(0, 9, $this->t('Consulta: ' . $this->fecha($consulta->fecha)), 0, 1);

        $medico = $consulta->user;
        if ($medico) {
            $prefijo = $medico->tipo == 1 ? 'Dra.' : 'Dr.';
            $pdf->SetFont('Helvetica', '', 10);
            $pdf->Cell(0, 6, $this->t('Atendido por: ' . $prefijo . ' ' . $medico->nombres . ' ' . $medico->apellidos), 0, 1);
        }
        $pdf->Ln(2);

        $this->campo($pdf, 'Motivo', $consulta->motivo);
        $this->campo($pdf, 'Enfermedad actual', $consulta->enfermedad);
        $this->campo($pdf, 'Antecedentes', $consulta->antecedentes);
        $this->campo($pdf, 'Neuro', $consulta->neuro);
        $this->campo($pdf, 'Neuro superior', $consulta->neuro_superior);
        $this->campo($pdf, 'Neuro pares', $consulta->neuro_pares);
        $this->campo($pdf, 'Neuro sistema', $consulta->neuro_sistema);
        $this->campo($pdf, 'Neuro sensibilidad', $consulta->neuro_sensibilidad);
        $this->campo($pdf, 'Neuro taxia', $consulta->neuro_taxia);
        $this->campo($pdf, 'Neuro praxia', $consulta->neuro_praxia);
        $this->campo($pdf, 'Laboratorio básico', $consulta->laboratorio_basico);
        $this->campo($pdf, 'Laboratorio complementario', $consulta->laboratorio_complementario);

        $pdf->Ln(2);
        $this->campo($pdf, 'Diagnóstico', $consulta->diagnostico, true);
        $this->campo($pdf, 'Tratamiento', $consulta->tratamiento);
        $this->campo($pdf, 'Observaciones', $consulta->observaciones);

        if ($consulta->proxima_cita) {
            $this->campo($pdf, 'Próxima cita', $this->fecha($consulta->proxima_cita));
        }
    }

    private function encabezadoPaciente(PDFGenerator $pdf, Paciente $paciente)
    {
        $pdf->AddPage();
        $pdf->SetFont('Helvetica', 'B', 15);
        $pdf->Cell(0, 8, $this->t('SISMED - Historial de Diagnósticos'), 0, 1);
        $pdf->SetFont('Helvetica', '', 10);
        $pdf->Cell(0, 6, $this->t('Paciente: ' . $paciente->nombres . ' ' . $paciente->apellidos . '    C.I.: ' . $paciente->cedula . '    Edad: ' . $paciente->edad), 0, 1);
        $pdf->SetDrawColor(180, 180, 180);
        $pdf->Line(15, $pdf->GetY(), 195, $pdf->GetY());
        $pdf->Ln(4);
    }

    private function campo(PDFGenerator $pdf, $label, $valor, $forzar = false)
    {
        $valor = trim((string) $valor);
        if (!$forzar && ($valor === '' || $valor === '0' || $valor === 'N/A')) {
            return;
        }
        $pdf->SetFont('Helvetica', 'B', 10);
        $pdf->MultiCell(0, 6, $this->t($label . ':'));
        $pdf->SetFont('Helvetica', '', 10);
        $pdf->MultiCell(0, 6, $this->t($valor !== '' ? $valor : 'N/A'));
        $pdf->Ln(2);
    }

    private function fecha($valor)
    {
        try {
            return Carbon::parse($valor)->format('d/m/Y');
        } catch (\Exception $e) {
            return (string) $valor;
        }
    }

    private function t($texto)
    {
        return mb_convert_encoding((string) $texto, 'Windows-1252', 'UTF-8');
    }

    private function descargar(PDFGenerator $pdf, $nombre, $inline = false)
    {
        return response($pdf->Output('S'), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => ($inline ? 'inline' : 'attachment') . '; filename="' . $nombre . '"',
        ]);
    }

    public function verificarPacientes(Request $request)
    {
        $search = trim((string) $request->query('search', ''));

        $pacientes = Paciente::with(['ultimaConsulta', 'user'])
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nombres', 'like', '%' . $search . '%')
                        ->orWhere('apellidos', 'like', '%' . $search . '%')
                        ->orWhere('cedula', $search);
                });
            })
            ->paginate(7)
            ->appends(['search' => $search]);

        return view('pacientes.verificar', compact('pacientes', 'search'));
    }
}
