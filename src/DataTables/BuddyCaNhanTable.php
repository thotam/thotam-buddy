<?php

namespace Thotam\ThotamBuddy\DataTables;

use Auth;
use Thotam\ThotamTeam\Models\Nhom;
use Thotam\ThotamBuddy\Models\Buddy;
use Thotam\ThotamBuddy\Models\BuddyTrangThai;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\TimeColumn;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Illuminate\Database\Eloquent\Builder;

class BuddyCaNhanTable extends LivewireDatatable
{
    public $exportable = true;
    public $model = Buddy::class;
    public $hr, $nguoihuongdan_of_buddy_ids;

    public function __construct()
    {
        $this->hr = Auth::user()->hr;
        $this->listeners['refreshComponent'] = '$refresh';
        $this->nguoihuongdan_of_buddy_ids = $this->hr->nguoihuongdan_of_buddy_ids;
    }

    public function builder()
    {
        return $this->model::query()->where('buddies.active', true)->where(function(Builder $query) {
            $query->where('buddies.hr_key', $this->hr->key)
                  ->orWhereHas('nguoihuongdans', function (Builder $query2) {
                        $query2->where('buddy_nguoihuongdans.hr_key', $this->hr->key);
                    });
        })->with(['hr', 'nhom']);

        //return $this->model::query()->where('buddies.active', true)->where('buddies.hr_key', $this->hr->key)->with(['hr', 'nhom']);
    }

    public function columns()
    {
        return [

            Column::callback(['id', 'trangthai_id', 'hr_key'], function ($id, $trangthai_id, $hr_key) {
                return view('thotam-buddy::table-actions.buddy-canhan-table-actions', ['id' => $id, 'trangthai_id' => $trangthai_id, 'nguoihuongdan_of_buddy_ids' => $this->nguoihuongdan_of_buddy_ids, 'isMine' => $this->hr->key == $hr_key]);
            })->label("Action"),

            Column::name('buddy_code')->label("Mã Buddy")->filterable()->searchable(),

            Column::name('hr_key')->label("Mã nhân viên")->filterable()->searchable(),

            Column::name('hr.hoten')->label("Họ và tên")->filterable()->searchable(),

            Column::name('nhom.full_name')->label("Nhóm")->filterable($this->nhoms)->searchable(),

            DateColumn::name('created_at')->label("Thời gian đăng ký")->filterable()->format("d-m-Y H:i:s"),

            Column::name('trangthai.trangthai')->label("Trạng thái")->filterable($this->trangthais),

            Column::name('nguoihuongdans.hoten')->label("Người hướng dẫn")->filterable(),

            Column::name('nhucau')->label("Nhu cầu đào tạo"),

            Column::name('ghichu')->label("Thông tin khác"),
        ];
    }

    public function getNhomsProperty()
    {
        $nhom_arrays = $this->hr->quanly_of_nhoms;
        $nhom_arrays = $nhom_arrays->merge($this->hr->thanhvien_of_nhoms);

        return $nhom_arrays->pluck("full_name");
    }

    public function getTrangthaisProperty()
    {
        return BuddyTrangThai::pluck('trangthai');
    }
}