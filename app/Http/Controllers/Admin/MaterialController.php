<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Material;
use App\Subject;
class MaterialController extends Controller
{
    public function index(){
        $materials = Material::with(['subject'])->paginate(25);
        return view('admin.materials.index', compact('materials'));
    }
    public function create(){
        $subjects = Subject::all();
        return view('admin.materials.create', compact('subjects'));
    }
    public function store(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'nullable|numeric|min:0',
            'book' => 'array|max:3',
            'workbook' => 'array|max:5',
            'media' => 'array|max:25',
            'media.*' => 'mimes:audio/mpeg,mpga,mp3,wav',
            'book.*' => 'mimes:pdf',
            'workbook.*' => 'mimes:pdf'
        ]);
        $material = Material::create($request->only(['name', 'price', 'available', 'subject_id']));
        if($request->has('book')){
            foreach($request->book as $file){
                $material->files()->create($this->getFileItem($file, 'book', $material->id));
            }
        }
        if($request->has('workbook')){
            foreach($request->workbook as $file){
                $material->files()->create($this->getFileItem($file, 'workbook', $material->id));
            }
        }
        if($request->has('media')){
            foreach($request->media as $file){
                $material->files()->create($this->getFileItem($file, 'media', $material->id));
            }
        }
        session()->flash('success', 'Материал успешно добавлен');
        return redirect()->route('admin.materials.index');
    }
    public function edit(Material $material){
        $subjects = Subject::all();
        $material->load(['files']);
        return view('admin.materials.edit', compact('material', 'subjects'));
    }
    private function getFileItem($file, $category, $id){
        return [
            'category' => $category,
            'name' => $file->getClientOriginalName(),
            'size' => $file->getSize(),
            'ext' => $file->extension(),
            'src' => $file->store('materials/'.$id)
        ];
    }
}
