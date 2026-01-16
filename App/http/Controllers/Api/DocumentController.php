<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function upload(Request $req)
    {
        $req->validate([
            'file' => 'required|file',
            'case_id' => 'nullable|exists:cases,id'
        ]);

        $file = $req->file('file');
        $path = $file->store('documents');

        $doc = Document::create([
            'case_id' => $req->case_id,
            'type' => $req->type ?? 'unknown',
            'file_name' => $file->getClientOriginalName(),
            'storage_path' => $path,
            'uploaded_by' => $req->user()->id ?? null,
        ]);

        $url = Storage::temporaryUrl($path, now()->addMinutes(60));
        return response()->json(['document' => $doc, 'url' => $url]);
    }

    public function download(Document $document)
    {
        return Storage::download($document->storage_path, $document->file_name);
    }
}
