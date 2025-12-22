<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class LegalController extends Controller
{
    public function impressum(): View 
    { 
        return view('tenant.legal.impressum'); 
    }
    
    public function datenschutz(): View 
    { 
        return view('tenant.legal.datenschutz'); 
    }
    
    public function terms(): View 
    { 
        return view('tenant.legal.terms'); 
    }
}