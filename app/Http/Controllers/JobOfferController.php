<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobOffer; // Asegúrate de tener un modelo JobOffer

class JobOfferController extends Controller
{
    public function index()
    {
        $jobOffers = JobOffer::all(); // O cualquier lógica para obtener las ofertas de trabajo
        return view('job_offers.index', compact('jobOffers'));
    }
}
