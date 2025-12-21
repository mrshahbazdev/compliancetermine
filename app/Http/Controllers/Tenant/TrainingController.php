<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\{Employee, Category, Training, Tenant};
use Illuminate\Http\Request;
use Carbon\Carbon;

class TrainingController extends Controller
{
    /**
     * Employee ki sab trainings manage karne ka view
     */
    public function index(string $tenantId, string $employeeId)
    {
        $employee = Employee::with('trainings.category')->findOrFail($employeeId);
        $categories = Category::all();
        return view('tenant.trainings.index', compact('employee', 'categories'));
    }

    /**
     * Naya training record save ya update karna
     */
    public function store(Request $request, string $tenantId, string $employeeId)
    {
    $request->validate([
        'category_id' => 'required|exists:categories,id',
        'last_event_date' => 'required|date',
        'duration_days' => 'required|integer|min:1',
        'certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048', // Max 2MB
    ]);

    $lastEvent = \Carbon\Carbon::parse($request->last_event_date);
    $expiryDate = $lastEvent->copy()->addDays((int) $request->duration_days);

    // File Upload Logic
    $filePath = null;
    if ($request->hasFile('certificate')) {
        // Tenant specific folder mein save karein
        $filePath = $request->file('certificate')->store("tenants/{$tenantId}/certificates", 'public');
    }

    $data = [
        'last_event_date' => $request->last_event_date,
        'duration_days' => $request->duration_days,
        'expiry_date' => $expiryDate,
    ];

    if ($filePath) {
        $data['certificate_path'] = $filePath;
    }

    Training::updateOrCreate(
        ['employee_id' => $employeeId, 'category_id' => $request->category_id],
        $data
    );

    return redirect()->back()->with('success', 'Training und Zertifikat gespeichert.');
    }

    /**
     * CALENDAR VIEW (Jis ka error aa raha tha)
     */
    public function calendar(string $tenantId)
    {
        $tenant = Tenant::findOrFail($tenantId);
        
        // Abhi ke liye sirf view return karte hain, data hum Phase 5 mein fetch karenge
        return view('tenant.calendar.index', compact('tenant'));
    }
}