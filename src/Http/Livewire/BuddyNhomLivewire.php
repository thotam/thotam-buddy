<?php

namespace Thotam\ThotamBuddy\Http\Livewire;

use Auth;
use Livewire\Component;
use Thotam\ThotamHr\Models\HR;
use Thotam\ThotamTeam\Models\Nhom;
use Thotam\ThotamBuddy\Models\Buddy;
use Thotam\ThotamBuddy\Models\BuddyDuyet;
use Thotam\ThotamBuddy\Traits\BuddyTraits;
use Thotam\ThotamBuddy\Models\BuddyDanhGia;
use Thotam\ThotamBuddy\Models\BuddyTieuChiDuyet;

class BuddyNhomLivewire extends Component
{
    use BuddyTraits;

    public $ngayvaolam, $nguoihuongdan, $duyet_ketqua, $duyet_ghichu;
    public $nguoihuongdan_arrays = [];
    public $buddy_duyet;
    public $danhgia_ketqua, $danhgia_thuongtien, $danhgia_noidung, $danhgia_ghichu;

    /**
     * @var bool
     */
    public $addStatus = false;
    public $viewStatus = false;
    public $editStatus = false;
    public $deleteStatus = false;
    public $duyetStatus = false;
    public $danhgiaStatus = false;

    /**
     * Các biển sự kiện
     *
     * @var array
     */
    protected $listeners = ['dynamic_update_method', 'edit_buddy', 'delete_buddy', 'duyet_buddy', 'len_tieuchi_buddy', 'view_buddy', 'danhgia_buddy'];

    /**
     * Validation rules
     *
     * @var array
     */
    protected function rules() {
        return [
            'nhom_id' => 'required|exists:nhoms,id',
            'quanly_hr_key' => 'required|exists:hrs,key',
            'email' => 'required|email',
            'quanly_email' => 'required|email',
            'nhucau' => 'required|string',
            'ghichu' => 'nullable|string',
            'ngayvaolam' => 'required|date_format:d-m-Y',
            'nguoihuongdan' => 'required|array',
            'nguoihuongdan.*' => 'required|exists:hrs,key',
            'duyet_ketqua' => 'required|in:7,9',
            'duyet_ghichu' => 'nullable|string',
            'duyet_tieuchi_ghichu' => 'nullable|string',
            'tentieuchi' => 'required|string',
            'noidung' => 'required|string',
            'ketqua_candat' => 'required|string',
            'deadline' => 'required|date_format:d-m-Y',
            'len_tieuchi_ghichu' => 'nullable|string',
            'danhgia_ketqua' => 'required|in:25,27',
            'danhgia_thuongtien' => 'required|in:1,0',
            'danhgia_noidung' => 'required|string',
            'danhgia_ghichu' => 'nullable|string',
        ];
    }

    /**
     * Custom attributes
     *
     * @var array
     */
    protected $validationAttributes = [
        'nhom_id' => 'nhóm',
        'quanly_hr_key' => 'quản lý',
        'email' => 'email của bạn',
        'quanly_email' => 'email quản lý của bạn',
        'nhucau' => 'nhu cầu đào tạo',
        'ghichu' => 'ghi chú',
        'ngayvaolam' => 'ngày bắt đầu thử việc',
        'nguoihuongdan' => 'người hướng dẫn',
        'nguoihuongdan.*' => 'người hướng dẫn',
        'duyet_ketqua' => 'kết quả duyệt',
        'duyet_ghichu' => 'ghi chú',
        'duyet_tieuchi_ghichu' => 'ghi chú',
        'tentieuchi' => 'tên tiêu chí',
        'noidung' => 'nội dung',
        'ketqua_candat' => 'kết quả cần đạt',
        'deadline' => 'thời hạn thực hiện',
        'len_tieuchi_ghichu' => 'ghi chú',
        'danhgia_ketqua' => 'kết quả đánh giá',
        'danhgia_thuongtien' => 'thưởng tiền',
        'danhgia_noidung' => 'nội dung đánh giá',
        'danhgia_ghichu' => 'ghi chú',
    ];

    /**
     * cancel
     *
     * @return void
     */
    public function cancel()
    {
        $this->dispatchBrowserEvent('unblockUI');
        $this->dispatchBrowserEvent('hide_modals');
        $this->reset();
        $this->addStatus = false;
        $this->editStatus = false;
        $this->viewStatus = false;
        $this->deleteStatus = false;
        $this->duyetStatus = false;
        $this->lenTieuChiStatus = false;
        $this->addTieuChiStatus = false;
        $this->deleteTieuChiStatus = false;
        $this->editTieuChiStatus = false;
        $this->baocaoStatus = false;
        $this->baoCaoTieuChiStatus = false;
        $this->danhgiaStatus = false;
        $this->resetValidation();
        $this->emitTo('thotam-buddy::buddy-nhom-datatable', 'refreshComponent');
        $this->mount();
    }

    public function render()
    {
        return view('thotam-buddy::livewire.nhom.nhom-livewire');
    }

    /**
     * mount data
     *
     * @return void
     */
    public function mount()
    {
        $this->hr = Auth::user()->hr;
        $this->quanly_of_nhomids = $this->hr->quanly_of_nhoms->pluck('id');
    }
        
    /**
     * updatedDuyetKetqua
     *
     * @return void
     */
    public function updatedDuyetKetqua()
    {
        $this->dispatchBrowserEvent('dynamic_update');
    }

    /**
     * duyet_buddy
     *
     * @param  mixed $buddy
     * @return void
     */
    public function duyet_buddy(Buddy $buddy)
    {
        $this->buddy = $buddy;

        if ($this->buddy->trangthai_id !== 5 && $this->buddy->trangthai_id !== 7 && $this->buddy->trangthai_id !== 9) {
            $this->dispatchBrowserEvent('toastr', ['type' => 'warning', 'title' => "Thất bại", 'message' => "Buddy đang ở trạng thái không thể duyệt"]);
            $this->cancel();
            return null;
        }

        if ((!$this->quanly_of_nhomids->contains($this->buddy->nhom_id)) && (!$this->hr->hasAnyRole(["super-admin", "admin", "admin-buddy"])) && (!$this->hr->hasAnyPermission(["duyet-buddy"]))) {
            $this->dispatchBrowserEvent('toastr', ['type' => 'warning', 'title' => "Thất bại", 'message' => "Chỉ người đăng ký, quản lý của người đăng ký hoặc Admin mới có quyền xóa Buddy này"]);
            $this->cancel();
            return null;
        }

        $this->duyetStatus = true;
        $this->modal_title = "Duyệt Buddy";
        $this->toastr_message = "Duyệt Buddy thành công";
        $this->ngayvaolam = !!$this->hr->ngaythuviec ? $this->hr->ngaythuviec->format("d-m-Y") : NULL;

        $this->nguoihuongdan_arrays = Nhom::find($this->buddy->nhom_id)->nhom_has_quanlys->pluck("hoten", "key");
        $this->nguoihuongdan_arrays = $this->nguoihuongdan_arrays->merge(Nhom::find($this->buddy->nhom_id)->nhom_has_thanhviens->pluck("hoten", "key"));

        $this->buddy_duyet = $this->buddy->buddy_duyet;

        

        if (!!$this->buddy_duyet) {
            $this->duyet_ketqua = $this->buddy_duyet->ketqua;
            $this->duyet_ghichu = $this->buddy_duyet->ghichu;
            $this->nguoihuongdan = $this->buddy->nguoihuongdans->pluck("key");
        }

        $this->dispatchBrowserEvent('unblockUI');
        $this->dispatchBrowserEvent('dynamic_update');
        $this->dispatchBrowserEvent('show_modal', "#duyet_buddy_modal");
    }
    
    /**
     * save_duyet_buddy
     *
     * @return void
     */
    public function save_duyet_buddy()
    {
        if ($this->buddy->trangthai_id !== 5 && $this->buddy->trangthai_id !== 7 && $this->buddy->trangthai_id !== 9) {
            $this->dispatchBrowserEvent('unblockUI');
            $this->dispatchBrowserEvent('toastr', ['type' => 'warning', 'title' => "Thất bại", 'message' => "Buddy đang ở trạng thái không thể duyệt"]);
            return null;
        }

        if ((!$this->quanly_of_nhomids->contains($this->buddy->nhom_id)) && (!$this->hr->hasAnyRole(["super-admin", "admin", "admin-buddy"])) && (!$this->hr->hasAnyPermission(["duyet-buddy"]))) {
            $this->dispatchBrowserEvent('unblockUI');
            $this->dispatchBrowserEvent('toastr', ['type' => 'warning', 'title' => "Thất bại", 'message' => "Chỉ người đăng ký, quản lý của người đăng ký hoặc Admin mới có quyền duyệt Buddy này"]);
            return null;
        }

        $this->dispatchBrowserEvent('unblockUI');
        $this->validate([
            'ngayvaolam' => 'required|date_format:d-m-Y',
            'nguoihuongdan' => $this->duyet_ketqua == 9 ? 'required' : 'nullable' . '|array',
            'nguoihuongdan.*' => 'required|exists:hrs,key',
            'duyet_ketqua' => 'required|in:7,9',
            'duyet_ghichu' => 'nullable|string',
        ]);
        $this->dispatchBrowserEvent('blockUI');

        try {
            $this->buddy->buddy_duyet()->delete();

            $this->buddy_duyet = BuddyDuyet::create([
                "ketqua" => $this->duyet_ketqua,
                "hr_key" => $this->hr->key,
                "active" => true,
                "ghichu" => $this->duyet_ghichu,
            ]);

            $this->buddy->buddy_duyet()->save($this->buddy_duyet);

            if ($this->duyet_ketqua == 9) {
                $this->buddy->nguoihuongdans()->sync($this->nguoihuongdan);
            }
            
            $this->buddy->update([
                "trangthai_id" => $this->duyet_ketqua,
                "ngayvaolam" => $this->ngayvaolam
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            $this->dispatchBrowserEvent('unblockUI');
            $this->dispatchBrowserEvent('toastr', ['type' => 'warning', 'title' => "Thất bại", 'message' => implode(" - ", $e->errorInfo)]);
            return null;
        } catch (\Exception $e2) {
            $this->dispatchBrowserEvent('unblockUI');
            $this->dispatchBrowserEvent('toastr', ['type' => 'warning', 'title' => "Thất bại", 'message' => $e2->getMessage()]);
            return null;
        }

        //Đẩy thông tin về trình duyệt
        $this->dispatchBrowserEvent('dt_draw');
        $toastr_message = $this->toastr_message;
        $this->cancel();
        $this->dispatchBrowserEvent('toastr', ['type' => 'success', 'title' => "Thành công", 'message' => $toastr_message]);
    }
    
    /**
     * duyet_tieuchi_buddy
     *
     * @param  mixed $ketqua
     * @return void
     */
    public function duyet_tieuchi_buddy(int $ketqua)
    {
        if (!$this->quanly_of_nhomids->contains($this->buddy->nhom_id) && !$this->hr->hasAnyRole(["super-admin", "admin", "admin-buddy"])) {
            $this->dispatchBrowserEvent('unblockUI');
            $this->dispatchBrowserEvent('toastr', ['type' => 'warning', 'title' => "Thất bại", 'message' => "Bạn không có quyền duyệt tiêu chí của Buddy này"]);
            return null;
        }

        $this->buddy_tieuchies = Buddy::find($this->buddy->id)->buddy_tieuchies;

        if (count($this->buddy_tieuchies) == 0) {
            $this->dispatchBrowserEvent('unblockUI');
            $this->dispatchBrowserEvent('toastr', ['type' => 'warning', 'title' => "Thất bại", 'message' => "Buddy này chưa có tiêu chí nào"]);
            return null;
        }

        if ($ketqua != 15 && $ketqua != 19) {
            $this->dispatchBrowserEvent('unblockUI');
            $this->dispatchBrowserEvent('toastr', ['type' => 'warning', 'title' => "Thất bại", 'message' => "Kết quả duyệt không hợp lệ"]);
            return null;
        }

        $this->dispatchBrowserEvent('unblockUI');
        $this->validate([
            'duyet_tieuchi_ghichu' => 'nullable|string',
        ]);
        $this->dispatchBrowserEvent('blockUI');

        try {
            $BuddyTieuChiDuyet = BuddyTieuChiDuyet::create(
                [
                    "ketqua" => $ketqua,
                    "hr_key" => $this->hr->key,
                    "active" => true,
                    "ghichu" => $this->duyet_tieuchi_ghichu,
                ]
            );

            $this->buddy->buddy_tieuchi_duyet()->delete();

            $this->buddy->buddy_tieuchi_duyet()->save($BuddyTieuChiDuyet);

            $this->buddy->update([
                "trangthai_id" => $ketqua,
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            $this->dispatchBrowserEvent('unblockUI');
            $this->dispatchBrowserEvent('toastr', ['type' => 'warning', 'title' => "Thất bại", 'message' => implode(" - ", $e->errorInfo)]);
            return null;
        } catch (\Exception $e2) {
            $this->dispatchBrowserEvent('unblockUI');
            $this->dispatchBrowserEvent('toastr', ['type' => 'warning', 'title' => "Thất bại", 'message' => $e2->getMessage()]);
            return null;
        }

        //Đẩy thông tin về trình duyệt
        $this->cancel();
        $this->dispatchBrowserEvent('toastr', ['type' => 'success', 'title' => "Thành công", 'message' => "Duyệt tiêu chí thành công"]);
    }

    /**
     * danhgia_buddy
     *
     * @param  mixed $buddy
     * @return void
     */
    public function danhgia_buddy(Buddy $buddy)
    {
        $this->buddy = $buddy;

        if ($this->buddy->trangthai_id !== 23) {
            $this->dispatchBrowserEvent('toastr', ['type' => 'warning', 'title' => "Thất bại", 'message' => "Buddy đang ở trạng thái không thể đánh giá"]);
            $this->cancel();
            return null;
        }

        if ((!$this->quanly_of_nhomids->contains($this->buddy->nhom_id)) && (!$this->hr->hasAnyRole(["super-admin", "admin", "admin-buddy"])) && (!$this->hr->hasAnyPermission(["danhgia-buddy"]))) {
            $this->dispatchBrowserEvent('toastr', ['type' => 'warning', 'title' => "Thất bại", 'message' => "Chỉ người đăng ký, quản lý của người đăng ký hoặc Admin mới có quyền đánh giá Buddy này"]);
            $this->cancel();
            return null;
        }

        $this->buddy_tieuchies = Buddy::find($this->buddy->id)->buddy_tieuchies;

        $this->danhgiaStatus = true;
        $this->modal_title = "Đánh giá Buddy";
        $this->toastr_message = "Đánh giá Buddy thành công";

        $this->dispatchBrowserEvent('unblockUI');
        $this->dispatchBrowserEvent('dynamic_update');
        $this->dispatchBrowserEvent('show_modal', "#danhgia_buddy_modal");
    }

    public function save_danhgia_buddy()
    {
        if ($this->buddy->trangthai_id !== 23) {
            $this->dispatchBrowserEvent('unblockUI');
            $this->dispatchBrowserEvent('toastr', ['type' => 'warning', 'title' => "Thất bại", 'message' => "Buddy đang ở trạng thái không thể đánh giá"]);
            return null;
        }

        if ((!$this->quanly_of_nhomids->contains($this->buddy->nhom_id)) && (!$this->hr->hasAnyRole(["super-admin", "admin", "admin-buddy"])) && (!$this->hr->hasAnyPermission(["danhgia-buddy"]))) {
            $this->dispatchBrowserEvent('unblockUI');
            $this->dispatchBrowserEvent('toastr', ['type' => 'warning', 'title' => "Thất bại", 'message' => "Chỉ người đăng ký, quản lý của người đăng ký hoặc Admin mới có quyền đánh giá Buddy này"]);
            return null;
        }

        $this->dispatchBrowserEvent('unblockUI');
        $this->validate([
            'danhgia_ketqua' => 'required|in:25,27',
            'danhgia_thuongtien' => 'required|in:1,0',
            'danhgia_noidung' => 'required|string',
            'danhgia_ghichu' => 'nullable|string',
        ]);
        $this->dispatchBrowserEvent('blockUI');

        try {
            $this->buddy->buddy_danhgia()->delete();

            $this->buddy_danhgia = BuddyDanhGia::create([
                "danhgia" => $this->danhgia_ketqua,
                "thuongtien" => $this->danhgia_thuongtien,
                "noidung" => $this->danhgia_noidung,
                "hr_key" => $this->hr->key,
                "active" => true,
                "ghichu" => $this->danhgia_ghichu,
            ]);

            $this->buddy->buddy_danhgia()->save($this->buddy_danhgia);
            
            $this->buddy->update([
                "trangthai_id" => $this->danhgia_ketqua,
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            $this->dispatchBrowserEvent('unblockUI');
            $this->dispatchBrowserEvent('toastr', ['type' => 'warning', 'title' => "Thất bại", 'message' => implode(" - ", $e->errorInfo)]);
            return null;
        } catch (\Exception $e2) {
            $this->dispatchBrowserEvent('unblockUI');
            $this->dispatchBrowserEvent('toastr', ['type' => 'warning', 'title' => "Thất bại", 'message' => $e2->getMessage()]);
            return null;
        }

        //Đẩy thông tin về trình duyệt
        $this->dispatchBrowserEvent('dt_draw');
        $toastr_message = $this->toastr_message;
        $this->cancel();
        $this->dispatchBrowserEvent('toastr', ['type' => 'success', 'title' => "Thành công", 'message' => $toastr_message]);
    }
}
