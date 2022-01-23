<?php

namespace App\Http\Controllers\Teacher;

use Illuminate\Http\Request;
use App\MaterialCat;
use App\Material;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Imagick;
use Carbon\Carbon;

class MaterialController extends Controller
{

    //
    // Только оплаченные аккаунты
    // Список категорий
    // список итемов
    // страницы

    public function index(Request $request){
        $active = auth()->user()->subscribes->where('end', '>=', Carbon::now())->first();
        if (!$active) return redirect()->route('teacher.subscribe.index');

        $catId = $request->get('cat');
        $cats = MaterialCat::where('parent_id', $catId)->get();
        $items = Material::where('cat_id', $catId)->get();
        $current = $catId ? MaterialCat::find($catId) : null;
        $breadcrumbs = [];

        if ($current) {
            $breadcrumbs[] = [
                'name' => $current->name,
                'cat' => $current->id,
            ];

            $parent = MaterialCat::find($current->parent_id);
            while ($parent) {
                $breadcrumbs[] = [
                    'name' => $parent->name,
                    'cat' => $parent->id,
                ];
                $parent = MaterialCat::find($parent->parent_id);
            }
        }
        $breadcrumbs[] = [
            'name' => 'Главная',
            'cat' => null,
        ];
        $breadcrumbs = array_reverse($breadcrumbs);
        return view('teacher.material', compact('cats', 'items', 'breadcrumbs'));
    }

    // Проверяем параметры
    // Ид пользователя
    // Ид документа
    // время
    // Cтраница
    // Соль
    // ключ
    // Генерация файла уже в модели

    public function file(Request $request){
        $doc = $request->get('doc');
        $page = $request->get('page');
        $key = $request->get('key');
        $type = $request->get('type');
        $user = auth()->user()->id;

        $file = Material::getFile($doc, $page, $key, $user, $type);
        if ($file) {
            return response()->file($file);
        } else {
            abort(404);
        }
    }

    public function show(Request $request, $id){
        $material = Material::findOrFail($id);
        $page = $request->get('page', 0);

        $breadcrumbs = [];

        $parent = MaterialCat::find($material->cat_id);
        while ($parent) {
            $breadcrumbs[] = [
                'name' => $parent->name,
                'cat' => $parent->id,
            ];
            $parent = MaterialCat::find($parent->parent_id);
        }

        $breadcrumbs[] = [
            'name' => 'Главная',
            'cat' => null,
        ];
        $breadcrumbs = array_reverse($breadcrumbs);

        return view('teacher.materialshow', compact('material', 'page', 'breadcrumbs'));
    }

    

}
