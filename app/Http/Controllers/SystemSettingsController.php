<?php

namespace App\Http\Controllers;

use App\Models\Notebook;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SystemSettingsController extends Controller
{
    /**
     * Display the system settings page.
     */
    public function index(): View
    {
        return view('settings.index', [
            'settings' => [
                'system_name' => 'NoteGov AI DILG',
                'organization' => 'Department of the Interior and Local Government',
                'timezone' => 'Asia/Manila',
                'language' => 'English',
                'maintenance_mode' => false,
            ],
            'featuredNotebooks' => Notebook::where('is_featured', true)->latest()->get(),
            'allNotebooks' => Notebook::latest()->get(),
            'storageUsage' => [
                'used' => 45.8, // Example GB
                'total' => 100, // Example GB
                'percentage' => 45.8,
            ]
        ]);
    }

    /**
     * Update system settings.
     */
    public function update(Request $request)
    {
        // Logic to update settings (e.g., in a settings table or .env)
        return back()->with('status', 'Settings updated successfully.');
    }
}
