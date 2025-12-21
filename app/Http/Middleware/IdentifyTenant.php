<?php

namespace App\Http\Middleware;

use App\Models\Tenant;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class IdentifyTenant
{
    public function handle(Request $request, Closure $next)
    {
        // 1. Route se tenantId uthaein (e.g. /tenant/tenant_123/...)
        $tenantId = $request->route('tenantId');
        
        if ($tenantId) {
            $tenant = Tenant::find($tenantId);
            
            if (!$tenant || !$tenant->isActive()) {
                abort(403, 'Tenant not found or inactive');
            }
            
            // 2. Data Isolation ke liye Session mein Tenant ID set karein
            // Yeh wahi ID hai jo hamara Global Scope use karega data filter karne ke liye
            Session::put('tenant_id', $tenant->id);
            
            // 3. Current Tenant ko views ke liye share karein
            view()->share('tenant', $tenant);
            
            // 4. App ka URL ya locale agar tenant specific hai toh yahan set kar sakte hain
        } else {
            // Agar route mein tenantId nahi hai (e.g. central landing page), toh session clear karein
            Session::forget('tenant_id');
        }

        return $next($request);
    }
}