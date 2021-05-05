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

class BuddyNhomTable extends LivewireDatatable
{
    public $exportable = true;
    public $model = Buddy::class;
    public $hr;

    public function __construct()
    {
        $this->hr = Auth::user()->hr;
        $this->listeners['refreshComponent'] = '$refresh';
    }

    public function builder()
    {
        $builder = $this->model::query()->where('buddies.active', true);

        if (!$this->hr->hasAnyRole(["super-admin", "admin", "admin-buddy"]) && !$this->hr->hasAnyPermission(["view-buddy"])) {
            $builder->whereIn('buddies.nhom_id', $this->quanlynhomids);
        }

        return $builder->with(['hr', 'nhom']);
    }

    public function columns()
    {
        return [
            Column::callback(['id', 'trangthai_id'], function ($id, $trangthai_id) {
                return view('thotam-buddy::table-actions.buddy-nhom-table-actions', ['id' => $id, 'trangthai_id' => $trangthai_id]);
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

    public function getQuanlynhomidsProperty()
    {
        $nhom_arrays = $this->hr->quanly_of_nhoms;

        return $nhom_arrays->pluck("id");
    }

    public function getTrangthaisProperty()
    {
        return BuddyTrangThai::pluck('trangthai');
    }
}