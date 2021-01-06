<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Conflict;
class ConflictController extends Controller
{
    public function index(){
        $conflicts = Conflict::paginate(25);
        return view('admin.conflicts.index', compact('conflicts'));
    }
}
