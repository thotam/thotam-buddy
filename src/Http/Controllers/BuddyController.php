<?php

namespace Thotam\ThotamBuddy\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Thotam\ThotamBuddy\DataTables\BuddyNhomTable2;

class BuddyController extends Controller
{
	/**
	 * canhan
	 *
	 * @return void
	 */
	public function canhan()
	{
		if (Auth::user()->hr->hasAnyPermission(["view-buddy", "add-buddy", "edit-buddy", "delete-buddy", "duyet-buddy",]) || Auth::user()->hr->is_thanhvien || Auth::user()->hr->is_quanly) {
			return view('thotam-buddy::canhan', ['title' => 'Buddy - Cá nhân']);
		} else {
			return view('errors.dynamic', [
				'error_code' => '403',
				'error_description' => 'Không có quyền truy cập',
				'title' => 'Buddy - Cá nhân',
			]);
		}
	}

	/**
	 * nhom
	 *
	 * @return void
	 */
	public function nhom(BuddyNhomTable2 $dataTable)
	{
		if (Auth::user()->hr->hasAnyPermission(["view-buddy", "add-buddy", "edit-buddy", "delete-buddy", "duyet-buddy",]) || Auth::user()->hr->is_quanly) {
			return $dataTable->render('thotam-buddy::nhom', ['title' => 'Buddy - Nhóm']);
			return view('thotam-buddy::nhom', ['title' => 'Buddy - Nhóm']);
		} else {
			return view('errors.dynamic', [
				'error_code' => '403',
				'error_description' => 'Không có quyền truy cập',
				'title' => 'Buddy - Nhóm',
			]);
		}
	}
}
