<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Program; // Asegúrate de tener un modelo Program

class ProgramController extends Controller
{
    public function index()
    {
        $programs = Program::all(); // O cualquier lógica para obtener los programas
        return view('programs.index', compact('programs'));
    }
}
