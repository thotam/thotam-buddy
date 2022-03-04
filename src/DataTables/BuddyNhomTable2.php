<?php

namespace Thotam\ThotamBuddy\DataTables;

use Auth;
use Carbon\Carbon;
use Thotam\ThotamHr\Models\HR;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Thotam\ThotamTeam\Models\Nhom;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Database\Eloquent\Builder;
use Thotam\ThotamBuddy\Models\Buddy;

class BuddyNhomTable2 extends DataTable
{
	public $hr, $table_id, $quanly_of_nhoms, $quanly_of_multi_level_nhoms;

	/**
	 * __construct
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->hr = Auth::user()->hr;
		$this->quanly_of_nhoms = $this->hr->quanly_of_nhoms;
		$this->quanly_of_multi_level_nhoms = $this->hr->quanly_of_multi_level_nhoms;
		$this->table_id = "nhom-table";
	}

	/**
	 * Build DataTable class.
	 *
	 * @param mixed $query Results from query() method.
	 * @return \Yajra\DataTables\DataTableAbstract
	 */
	public function dataTable($query)
	{
		return datatables()
			->eloquent($query)
			->filter(function ($query) {
			}, true)
			->addColumn('action', function ($query) {
				//return view('thotam-new-buddy::table-actions.nhom-table-actions', ['buddy' => $query, 'hr' => $this->hr, 'quanly_of_nhoms' => $this->quanly_of_nhoms, 'quanly_of_multi_level_nhoms' => $this->quanly_of_multi_level_nhoms]);
			})
			->addColumn('nguoihuongdan', function ($query) {
				if ($query->nguoihuongdans->count()) {
					return $query->nguoihuongdans->pluck('hoten')->implode(', ');
				} else {
					return NULL;
				}
			})
			->addColumn('thuongtien', function ($query) {
				if ($query->trangthai_id < 25) {
					return 'Chưa đánh giá';
				} elseif (!!$query->buddy_danhgia && !!$query->buddy_danhgia->thuongtien) {
					return 'Có';
				} else {
					return 'Không';
				}
			})
			->editColumn('created_at', function ($query) {
				if (!!$query->created_at) {
					return $query->created_at->format("d-m-Y H:i");
				} else {
					return NULL;
				}
			})
			->rawColumns(['action', 'file_kehoach', 'kpi', 'thuong']);
	}

	/**
	 * Get query source of dataTable.
	 *
	 * @param \Thotam\ThotamBuddy\Models\Buddy $model
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function query(Buddy $model)
	{
		$query = $model->newQuery()->where('buddies.active', true);

		if (!request()->has('order')) {
			$query->orderBy('buddies.id', 'desc');
		};


		return $query->with(['nguoihuongdans', 'buddy_danhgia', 'trangthai', 'nhom', 'hr']);
	}

	/**
	 * Optional method if you want to use html builder.
	 *
	 * @return \Yajra\DataTables\Html\Builder
	 */
	public function html()
	{
		return $this->builder()
			->setTableId($this->table_id)
			->columns($this->getColumns())
			->minifiedAjax("", NULL, [])
			->dom("<'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'row'<'col-sm-12 table-responsive't>><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>><B>")
			->buttons(
				Button::make('excel')->addClass("btn btn-success waves-effect")->text('<span class="fas fa-file-excel mx-2"></span> Export'),
				Button::make('reload')->addClass("btn btn-info waves-effect")->text('<span class="fas fa-filter mx-2"></span> Filter'),
			)
			->parameters([
				"autoWidth" => false,
				"lengthMenu" => [
					[10, 25, 50, -1],
					[10, 25, 50, "Tất cả"]
				],
				"order" => [],
				'initComplete' => 'function(settings, json) {
					var api = this.api();

					$(document).on("click", "#filter_submit", function(e) {
						api.draw(false);
						e.preventDefault();
					});

					window.addEventListener("dt_draw", function(e) {
						api.draw(false);
						e.preventDefault();
					})

					$("thead#' . $this->table_id . '-thead").insertAfter(api.table().header());

					api.buttons()
						.container()
						.removeClass("btn-group")
						.appendTo($("#datatable-buttons"));

					$("#datatable-buttons").removeClass("d-none")
				}',
			]);
	}

	/**
	 * Get columns.
	 *
	 * @return array
	 */
	protected function getColumns()
	{
		return [
			Column::make('buddy_code')
				->title("Mã đăng ký")
				->width(155)
				->addClass('text-center')
				->searchable(true)
				->orderable(false)
				->footer("Mã đăng ký"),
			Column::make('hr_key')
				->title("Mã nhân viên")
				->searchable(false)
				->orderable(false)
				->footer("Mã nhân viên"),
			Column::make('hr.hoten')
				->title("Họ và tên")
				->searchable(false)
				->orderable(false)
				->footer("Họ và tên"),
			Column::make('nhom.full_name')
				->title("Nhóm")
				->searchable(false)
				->orderable(false)
				->footer("Nhóm"),
			Column::make('created_at')
				->title("Thời gian đăng ký")
				->searchable(false)
				->orderable(false)
				->footer("Thời gian đăng ký"),
			Column::make('trangthai.trangthai')
				->title("Trạng thái")
				->searchable(false)
				->orderable(false)
				->footer("Trạng thái"),
			Column::make('thuongtien')
				->title("Đề xuất thưởng tiền")
				->searchable(false)
				->orderable(false)
				->footer("Đề xuất thưởng tiền"),
			Column::make('nguoihuongdan')
				->title("Người hướng dẫn")
				->searchable(false)
				->orderable(false)
				->footer("Người hướng dẫn"),
			Column::make('nhucau')
				->title("Nhu cầu đào tạo")
				->searchable(false)
				->orderable(false)
				->footer("Nhu cầu đào tạo"),
			Column::computed('ghichu')
				->title("Thông tin khác")
				->footer("Thông tin khác")
		];
	}

	/**
	 * Get filename for export.
	 *
	 * @return string
	 */
	protected function filename()
	{
		return 'Buddy nhóm ' . date('YmdHis');
	}
}
