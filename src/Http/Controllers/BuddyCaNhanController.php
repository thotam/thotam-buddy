<?php

namespace Thotam\ThotamBuddy\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

class BuddyCaNhanController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        if (Auth::user()->hr->hasAnyPermission(["view-buddy", "add-buddy", "edit-buddy", "delete-buddy", "duyet-buddy", ])) {
            return view('thotam-buddy::canhan', ['title' => 'Buddy - Cá nhân']);
        } else {
            return view('errors.dynamic', [
                'error_code' => '403',
                'error_description' => 'Không có quyền truy cập',
                'title' => 'Buddy - Cá nhân',
            ]);
        }
    }
}
