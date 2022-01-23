<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Imagick;
use Carbon\Carbon;

class Material extends Model
{
    public $userPages;
    const HASH = 'sdJ(#UT(Hw98hegih204HTY)@(H)*@H*)HGHW80hg89hg280hg2';
    public $timestamps = false;
    protected $fillable = ['name', 'subject_id', 'cat_id', 'pdf_path', 'page_first', 'page_count'];
    public function files(){
        return $this->morphMany(File::class, 'fileable');
    }
    public function subject(){
        return $this->belongsTo(Subject::class);
    }
    public function category(){
        return $this->belongsTo(MaterialCat::class);
    }

    public function link($page = 0, $type = 1){
        $time = Carbon::now();
        $user = ($type == 1) ? 0 : auth()->user()->id;
        return route('teacher.material.file', [
            'doc' => $this->id,
            'page' => $page,
            'type' => $type,
            'key' => md5($this->id.' '.$page.' '.$user.' '.$type.' '.$time->format('d.m.Y.H').' '.self::HASH)
        ]);
    }

    public function isBuy($i) {
        return \App\MaterialPageUser::where('page', $i)
                ->where('user_id', auth()->user()->id)
                ->where('material_id', $this->id)
                ->where( 'created_at', '>', Carbon::now()->subDays(1))
                ->count();
    }

    public function canBuyCount() {
        return 10 - \App\MaterialPageUser::where('user_id', auth()->user()->id)
                ->where('material_id', $this->id)
                ->where( 'created_at', '>', Carbon::now()->subDays(1))
                ->count();
    }

    public static function getFile($doc, $page, $key, $user, $type){
        $material = Material::find($doc);
        $r = public_path().'/pdf-file/error.png';
        if (!$material) {
            return $r;
        }
        if ($type == 1) {
            $r = public_path().'/pdf-file/'.md5($doc.' '.$page).'_preview.jpg';
            if (!file_exists($r)) {
                $img = new Imagick($material->pdf_path.'['.$page.']');
                $img->setImageBackgroundColor('white');
                $img = $img->mergeImageLayers( Imagick::LAYERMETHOD_FLATTEN );
                $img->scaleImage(59,84, true);
                $img->setImageCompressionQuality(100);
                $img->setImageFormat('jpeg');
                $img->writeImage($r);
                $img->destroy();
            }
        } else {
            if (!$material->isBuy($page)) {
                if ($material->canBuyCount() > 0) {
                    \App\MaterialPageUser::create([
                        'page' => $page,
                        'user_id' => auth()->user()->id,
                        'material_id' => $material->id
                    ]);
                } else {
                    return $r;
                }
            }
            $r = public_path().'/pdf-file/'.md5($doc.' '.$page).'.jpg';
            if (!file_exists($r)) {
                $material = Material::find($doc);
                $img = new Imagick($material->pdf_path.'['.$page.']');
                $img->setImageBackgroundColor('white');
                $img = $img->mergeImageLayers( Imagick::LAYERMETHOD_FLATTEN );
                $img->scaleImage(595, 842, true);
                $img->setImageCompressionQuality(100);
                $img->setImageFormat('jpeg');
                $img->writeImage($r);
                $img->destroy();
            }
        }
        return $r;
    }

    public function catHtml(){
        $r = [];
        $parent = MaterialCat::where('id', $this->cat_id)->first();
        while ($parent) {
            $r[] = '<span class="badge badge-primary">'.$parent->name.'</span>';
            $parent = $parent->parent;
        }
        $r = array_reverse($r);
        return implode('', $r);
        //
    }

}
