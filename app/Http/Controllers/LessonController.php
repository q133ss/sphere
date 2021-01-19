<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Lesson;
use App\Material;
use Storage;
use App\LessonBoard;
class LessonController extends Controller
{
    public function show(Lesson $lesson){
        $lesson->load(['student:id,name,surname', 'teacher:id,name,surname', 'subject', 'messages', 'messages.user:id,name', 'lesson_boards', 'files']);
        return $lesson;
    }
    public function addMaterial(Request $request, Lesson $lesson){
        $type = $request->type;
        if($type == 1){
            $request->validate([
                'file' => 'required|image|max: 2048'
            ]);
            $file = $lesson->files()->create([
                'name' => $request->file->getClientOriginalName(),
                'size' => $request->file->getSize(),
                'ext' => $request->file->extension(),
                'src' => $request->file->store('lessons/'.$lesson->id)
            ]);
            return $file;
        }elseif($type == 2){
            $material = Material::findOrFail($request->material_id);
            $page = $request->page;
            $file = $material->files[0];
            $path = public_path('storage/'.$file->src);
            $filename = microtime(true) . '.jpg';
            $newpath = public_path('/storage/lessons/'.$lesson->id.'/'.$filename);
            $pdf = new \Spatie\PdfToImage\Pdf($path);
            $pagecount = $pdf->getNumberOfPages();
            if($page < 0 || $page > $pagecount) return response()->json(['errors' => ['page' => 'Страница не существует']], 404);
            $pdf->setPage($page)->saveImage($newpath);
            $lesson->files()->create([
                'name' => $material->name . '(' . $page . ')',
                'ext' => 'jpg',
                'size' => Storage::size('lessons/'.$lesson->id.'/'.$filename),
                'src' => 'lessons/'.$lesson->id.'/'.$filename
            ]);
        }
    }
    public function saveBoard(Request $request, Lesson $lesson){
        $data = $request->data;
        if(!$lesson->lesson_boards()->count()){
            $lesson->lesson_boards()->create([
                'data' => $data,
                'name' => 'test'
            ]);
        }else{
            $board = $lesson->lesson_boards[0];
            $board->update([
                'data' => $data
            ]);
        }
    }
    public function done(Lesson $lesson){
        if($lesson->status == 'success') return false;
        $lesson->status = 'success';
        $lesson->save();
        $teacher = $lesson->teacher;
        $teacher->balance += $teacher->lesson_price;
        $teacher->save();
    }
}