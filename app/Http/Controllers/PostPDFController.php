<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use Barryvdh\DomPDF\Facade\Pdf;

class PostPDFController extends Controller
{
    public function exportPdf()
    {
        $activities =  Activity::where('subject_type', \App\Models\Post::class)->get();
        
        return Pdf::loadView('exports.activities', compact('activities'))
            ->download('activities.pdf');
    }
}
