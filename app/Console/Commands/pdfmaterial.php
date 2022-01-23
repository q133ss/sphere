<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Imagick;
use Carbon\Carbon;
use App\MaterialCat;
use App\Material;

class pdfmaterial extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'material:pdf2';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        DB::statement("SET foreign_key_checks=0");
        MaterialCat::truncate();
        Material::truncate();
        DB::statement("SET foreign_key_checks=1");
        $this->parseDir(resource_path().'/pdf');

        return 0;
    }

    public function parseDir($dir, $parent = null) {
        $scanned_directory = scandir($dir);
        $newParent = 0;
        foreach($scanned_directory as $path) {
            if ($path == '.' || $path == '..') continue;
            if (is_dir($dir.'/'.$path)) {
                $newParent = MaterialCat::where('parent_id', $parent)->where('name', $path)->first();
                if (!$newParent) {
                    if (!$parent) {
                        $newParent = MaterialCat::create(['name' => $path]);
                    } else {
                        if (is_string($parent)) {
                            dd([1, $parent]);
                        }
                        $item = MaterialCat::where('id', is_object($parent) ? $parent->id : $parent)->first();
                        if (!$item) {
                            dd([2, $parent]);
                        }
                        $newParent = $item->children()->create(['name' => $path]);
                        $newParent = $newParent->id;
                    }
                } else {
                    $newParent = $newParent->id;
                }
                $this->parseDir($dir.'/'.$path, $newParent);
            } else {
                $imagick = new Imagick();
                if(@$imagick->readImage($dir.'/'.$path)) {
                    $pageCount = $imagick->getNumberImages();
                    if ($pageCount > 0) {
                        $count = Material::where('pdf_path', $dir.'/'.$path)->count();
                        if ($count == 0) {
                            Material::create([
                                'name' => str_replace('.pdf', '', $path),
                                'cat_id' => $parent,
                                'pdf_path' => $dir.'/'.$path,
                                'page_first' => 0,
                                'page_count' => $pageCount
                            ]);
                        }
                    }
                }
            }
        }
    }



    private function makeDb($path) {
        $pathArr = explode('/', str_replace('/usr/share/nginx/sferachild.ru/resources/pdf/', '', $path));
        $parent = null;
        $lastParent = null;
        foreach($pathArr as $k => $p) {
            if (preg_match('/\.pdf$/', $p)) {
                $pageCount = 0;
                $imagick = new Imagick();
                $imagick->readImage($path);
                $pageCount = $imagick->getNumberImages();
                Material::create([
                    'name' => str_replace('.pdf', '', $p),
                    'cat_id' => $parent->id,
                    'pdf_path' => $path,
                    'page_first' => 0,
                    'page_count' => $pageCount
                ]);
            } else {
                if ($k == 0) {
                    $parent = MaterialCat::where('parent_id', null)->where('name', $p)->first();
                    if (!$parent) $parent = MaterialCat::create(['name' => $p]);
                } else {
                    $newParent = MaterialCat::where('parent_id', $parent->id)->where('name', $p)->first();
                    if (!$newParent) $newParent = $parent->children()->create(['name' => $p]);
                    $parent = $newParent;
                }
            }
        }

    }
}
