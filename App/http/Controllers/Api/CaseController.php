<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CaseStoreRequest;
use App\Models\CaseModel;
use App\Models\Vehicle;
use App\Models\Party;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CaseController extends Controller
{
    public function index(Request $req)
    {
        $q = CaseModel::with(['vehicle','declarant','receiver','cargo','inspections']);

        if ($req->filled('plate')) {
            $q->whereHas('vehicle', fn($v) => $v->where('plate_no', $req->plate));
        }

        if ($req->filled('hs')) {
            $q->whereHas('cargo', fn($c) => $c->where('hs_code', $req->hs));
        }

        return $q->paginate(15);
    }

    public function store(CaseStoreRequest $req)
    {
        return DB::transaction(function () use ($req) {
            $vehicle = Vehicle::firstOrCreate(
                ['plate_no' => $req->vehicle['plate_no']],
                ['country' => $req->vehicle['country']]
            );

            $decl = Party::firstOrCreate(
                ['name' => $req->declarant['name']],
                ['role' => 'declarant', 'country' => $req->declarant['country'] ?? null]
            );

            $case = CaseModel::create([
                'case_no' => 'CASE-' . Str::upper(Str::random(8)),
                'vehicle_id' => $vehicle->id,
                'declarant_id' => $decl->id,
                'status' => 'screening',
            ]);

            foreach ($req->cargo as $item) {
                $case->cargo()->create($item);
            }

            [$score, $factors] = $this->computeRisk($case);
            $case->update(['risk_score' => $score, 'risk_factors' => $factors]);

            return $case->load(['vehicle','cargo','declarant']);
        });
    }

    protected function computeRisk(CaseModel $case): array
    {
        $score = 0;
        $factors = [];

        foreach ($case->cargo as $item) {
            if ($item->value_eur > 10000) { $score += 40; $factors[] = 'high_value'; }
            if (str_starts_with($item->hs_code, '87')) { $score += 10; $factors[] = 'vehicle_parts'; }
        }

        if ($case->vehicle->country === 'RU') { $score += 20; $factors[] = 'origin_RU'; }

        $score = min(100, $score);
        return [$score, $factors];
    }

    public function show($id)
    {
        return CaseModel::with(['vehicle','cargo','declarant','receiver','inspections','documents'])
            ->findOrFail($id);
    }

    public function update(Request $req, $id)
    {
        $case = CaseModel::findOrFail($id);
        $case->update($req->only(['status']));
        return $case;
    }
}
