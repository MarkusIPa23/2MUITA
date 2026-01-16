<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\{Vehicle, Party, CaseModel, Inspection, Document, User};
use Illuminate\Support\Facades\Storage;

class ExportAppJson extends Command
{
    protected $signature = 'export:appjson {--path=public/app.json}';
    protected $description = 'Export demo data as app.json';

    public function handle()
    {
        $this->info('Starting export...');

        try {
            $data = [
                'spec_version' => '1.0',
                'exported_at' => now()->toISOString(),
                'total' => [
                    'vehicles' => Vehicle::count(),
                    'parties' => Party::count(),
                    'users' => User::count(),
                    'cases' => CaseModel::count(),
                    'inspections' => Inspection::count(),
                    'documents' => Document::count(),
                ],
                'vehicles' => Vehicle::all()->toArray(),
                'parties' => Party::all()->toArray(),
                'cases' => CaseModel::with('cargo','vehicle','declarant','receiver')->get()->toArray(),
                'inspections' => Inspection::all()->toArray(),
                'documents' => Document::all()->toArray(),
            ];

            $path = $this->option('path');
            Storage::put($path, json_encode($data, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE));
            
            $this->info("✓ Successfully exported to {$path}");
            return 0;
        } catch (\Exception $e) {
            $this->error("Export failed: {$e->getMessage()}");
            return 1;
        }
    }
}
