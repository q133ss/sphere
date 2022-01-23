<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Imagick;
use Carbon\Carbon;
use App\MaterialCat;
use App\Material;
use NcJoes\OfficeConverter\OfficeConverter;

class textmaterial extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'material:text';

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
        /*DB::statement("SET foreign_key_checks=0");
        MaterialCat::truncate();
        Material::truncate();
        DB::statement("SET foreign_key_checks=1");
*/
        $this->parseDir(resource_path().'/text', null, resource_path().'/pdf');
        return 0;
    }


    public function parseDir($dir, $parent, $to) {
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
                if (!is_dir($to.'/'.$path)) {
                    mkdir($to.'/'.$path);
                }
                $this->parseDir($dir.'/'.$path, $newParent, $to.'/'.$path);
            } else {
                $newName = explode('.', $path);
                $newName[count($newName) - 1] = 'pdf';
                $newPath = $to.'/'.implode('.', $newName);
                unset($newName[count($newName) - 1]);
                //$converter = (new OfficeConverter($dir.'/'.$path))->convertTo($newPath);
                exec('libreoffice7.2 --headless --invisible --convert-to pdf "'.($dir.'/'.$path).'" "'.implode('.', $newName).'" --outdir "'.$to.'"');
                unlink($dir.'/'.$path);
                
                $imagick = new Imagick();
                if(@$imagick->readImage($newPath)) {
                    $pageCount = $imagick->getNumberImages();
                    if ($pageCount > 0) {
                        $count = Material::where('pdf_path', $to.'/'.$path)->count();
                        if ($count == 0) {
                            Material::create([
                                'name' => implode('.', $newName),
                                'cat_id' => $parent,
                                'pdf_path' => $to.'/'.$path,
                                'page_first' => 0,
                                'page_count' => $pageCount
                            ]);
                        }
                    }
                }
            }
        }
    }
}
