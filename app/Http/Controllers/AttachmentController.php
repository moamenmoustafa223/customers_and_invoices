<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AttachmentController extends Controller
{
    public function index()
    {
        $attachments = Attachment::orderBy('id', 'desc')->paginate(25);
        return view('backend.pages.attachments.index', compact('attachments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'attachment_name' => 'required|string',
            'file'            => 'nullable|file|max:5048',
        ]);
    
        $data['user_id'] = Auth::id();
        $data['student_id'] = $request->student_id;
        $data['attachment_name'] = $request->attachment_name;
    
        if ($file = $request->file('file')) {
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
            $path = 'uploads/attachments/' . $filename;
    
            Storage::disk('s3')->put($path, file_get_contents($file), [
                'ServerSideEncryption' => 'AES256',
            ]);
    
            $data['file'] = Storage::disk('s3')->url($path);
        }
    
        Attachment::create($data);
    
        toast('تم الإضافة بنجاح', 'success');
        return redirect()->back();
    }
    
    public function destroy($id)
    {
        $attachment = Attachment::findOrFail($id);
    
        // حذف الملف من S3 إذا كان موجود
        if ($attachment->file) {
            $s3Path = ltrim(parse_url($attachment->file, PHP_URL_PATH), '/');
            if (Storage::disk('s3')->exists($s3Path)) {
                Storage::disk('s3')->delete($s3Path);
            }
        }
    
        $attachment->delete();
    
        toast('تم الحذف بنجاح', 'success');
        return redirect()->back();
    }
}
