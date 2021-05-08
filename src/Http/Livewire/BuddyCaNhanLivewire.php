<?php

namespace Thotam\ThotamBuddy\Http\Livewire;

use Auth;
use Livewire\Component;
use Thotam\ThotamHr\Models\HR;
use Thotam\ThotamTeam\Models\Nhom;
use Thotam\ThotamBuddy\Models\Buddy;
use Thotam\ThotamBuddy\Traits\BuddyTraits;
use Thotam\ThotamBuddy\Models\BuddyTieuChi;
use Thotam\ThotamBuddy\Models\BuddyTieuChiBaoCao;

class BuddyCaNhanLivewire extends Component
{
    use BuddyTraits;

    public $baocao_ketqua, $baocao_thoigian, $baocao_noidung, $baocao_ghichu;

    /**
     * @var bool
     */
    public $addStatus = false;
    public $viewStatus = false;
    public $editStatus = false;
    public $deleteStatus = false;

    /**
     * Các biển sự kiện
     *
     * @var array
     */
    protected $listeners = ['dynamic_update_method', 'add_buddy', 'edit_buddy', 'delete_buddy', 'len_tieuchi_buddy', 'view_buddy', 'baocao_buddy'];

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
            'tentieuchi' => 'required|string',
            'noidung' => 'required|string',
            'ketqua_candat' => 'required|string',
            'deadline' => 'required|date_format:d-m-Y',
            'len_tieuchi_ghichu' => 'nullable|string',
            'baocao_ketqua' => 'required|in:0,1',
            'baocao_thoigian' => 'required|date_format:d-m-Y',
            'baocao_noidung' => 'required|string',
            'baocao_ghichu' => 'nullable|string',
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
        'tentieuchi' => 'tên tiêu chí',
        'noidung' => 'nội dung',
        'ketqua_candat' => 'kết quả cần đạt',
        'deadline' => 'thời hạn thực hiện',
        'len_tieuchi_ghichu' => 'ghi chú',
        'baocao_ketqua' => 'kết quả thực hiện',
        'baocao_thoigian' => 'thời gian hoàn thành',
        'baocao_noidung' => 'nội dung báo cáo',
        'baocao_ghichu' => 'ghi chú',
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
        $this->lenTieuChiStatus = false;
        $this->addTieuChiStatus = false;
        $this->deleteTieuChiStatus = false;
        $this->editTieuChiStatus = false;
        $this->baocaoStatus = false;
        $this->baoCaoTieuChiStatus = false;
        $this->doneTieuChiStatus = false;
        $this->resetValidation();
        $this->emitTo('thotam-buddy::buddy-canhan-datatable', 'refreshComponent');
        $this->mount();
    }

    public function render()
    {
        return view('thotam-buddy::livewire.canhan.canhan-livewire');
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
     * add_buddy
     *
     * @return void
     */
    public function add_buddy()
    {
        if ($this->hr->cannot("add-buddy") && !$this->hr->is_thanhvien && !$this->hr->is_quanly) {
            $this->dispatchBrowserEvent('toastr', ['type' => 'warning', 'title' => "Thất bại", 'message' => "Bạn không có quyền thực hiện hành động này"]);
            $this->cancel();
            return null;
        }

        $this->addStatus = true;
        $this->modal_title = "Đăng ký Buddy";
        $this->toastr_message = "Đăng ký Buddy thành công";

        $this->hr_key = $this->hr->key;
        $this->hoten = $this->hr->hoten;
        $this->email = $this->hr->getMail("buddy");

        $nhom_arrays = $this->hr->quanly_of_nhoms;
        $nhom_arrays = $nhom_arrays->merge($this->hr->thanhvien_of_nhoms);
        $this->nhom_arrays = $nhom_arrays->pluck("full_name", "id");
        
        if (count($this->nhom_arrays) == 1) {
            $this->nhom_id = $nhom_arrays->first()->id;
            $this->updatedNhomId();
        } else {
            $this->quanly_arrays = [];
        }

        $this->dispatchBrowserEvent('unblockUI');
        $this->dispatchBrowserEvent('dynamic_update');
        $this->dispatchBrowserEvent('show_modal', "#add_edit_buddy_modal");
    }

    public function baocao_buddy(Buddy $buddy)
    {
        $this->buddy = $buddy;

        if ($this->buddy->trangthai_id != 19 && $this->buddy->trangthai_id != 21) {
            $this->dispatchBrowserEvent('toastr', ['type' => 'warning', 'title' => "Thất bại", 'message' => "Buddy này đang ở trạng thái không thể báo cáo tiêu chí"]);
            $this->cancel();
            return null;
        }

        if ($this->buddy->hr_key != $this->hr->key) {
            $this->dispatchBrowserEvent('toastr', ['type' => 'warning', 'title' => "Thất bại", 'message' => "Bạn không phải là người đăng ký Buddy này"]);
            $this->cancel();
            return null;
        }

        $this->buddy_tieuchies = Buddy::find($this->buddy->id)->buddy_tieuchies;

        $this->baocaoStatus = true;
        $this->modal_title = "Báo cáo Buddy";
        $this->toastr_message = "Báo cáo Buddy thành công";

        $this->dispatchBrowserEvent('unblockUI');
        $this->dispatchBrowserEvent('dynamic_update');
        $this->dispatchBrowserEvent('show_modal', "#baocao_buddy_modal");
    }
    
    /**
     * back_baocao_buddy
     *
     * @return void
     */
    public function back_baocao_buddy()
    {
        $this->baoCaoTieuChiStatus = false;
        $this->doneTieuChiStatus = false;
        $this->baocaoStatus = true;
        $this->modal_title = "Báo cáo Buddy";
        $this->toastr_message = "Báo cáo Buddy thành công";
        $this->dispatchBrowserEvent('unblockUI');
        $this->dispatchBrowserEvent('dynamic_update');
        $this->reset(['baocao_ketqua', 'baocao_thoigian', 'baocao_noidung', 'baocao_ghichu' ]);
    }

    /**
     * baocao_tieuchi_buddy
     *
     * @param  mixed $tieuchi
     * @return void
     */
    public function baocao_tieuchi_buddy(BuddyTieuChi $tieuchi)
    {
        $this->buddy_tieuchi = $tieuchi;

        $this->baoCaoTieuChiStatus = true;
        $this->baocaoStatus = false;
        $this->modal_title = "Báo cáo Tiêu chí Buddy";
        $this->toastr_message = "Báo cáo Tiêu chí Buddy thành công";

        $this->dispatchBrowserEvent('unblockUI');
        $this->dispatchBrowserEvent('dynamic_update');
    }
    
    public function baocao_tieuchi_buddy_save()
    {
        if ($this->buddy->trangthai_id != 19 && $this->buddy->trangthai_id != 21) {
            $this->dispatchBrowserEvent('unblockUI');
            $this->dispatchBrowserEvent('toastr', ['type' => 'warning', 'title' => "Thất bại", 'message' => "Buddy này đang ở trạng thái không thể báo cáo tiêu chí"]);
            return null;
        }

        if ($this->buddy->hr_key != $this->hr->key) {
            $this->dispatchBrowserEvent('unblockUI');
            $this->dispatchBrowserEvent('toastr', ['type' => 'warning', 'title' => "Thất bại", 'message' => "Bạn không phải là người đăng ký Buddy này"]);
            return null;
        }

        if (!!$this->buddy_tieuchi->lock) {
            $this->dispatchBrowserEvent('unblockUI');
            $this->dispatchBrowserEvent('toastr', ['type' => 'warning', 'title' => "Thất bại", 'message' => "Tiêu chí này đã khóa báo cáo"]);
            return null;
        }

        $this->dispatchBrowserEvent('unblockUI');
        $this->validate([
            'baocao_ketqua' => 'required|in:0,1',
            'baocao_thoigian' => 'required|date_format:d-m-Y',
            'baocao_noidung' => 'required|string',
            'baocao_ghichu' => 'nullable|string',
        ]);
        $this->dispatchBrowserEvent('blockUI');

        try {
            $buddy_tieuchi_baocao = BuddyTieuChiBaoCao::create(
                [
                    "ketqua" => $this->baocao_ketqua,
                    "thoigian" => $this->baocao_thoigian,
                    "noidung" => $this->baocao_noidung,
                    "ghichu" => $this->baocao_ghichu,
                    "hr_key" => $this->hr->key,
                    "active" => true,
                ]
            );


            $this->buddy_tieuchi->baocaos()->save($buddy_tieuchi_baocao);

            if ($this->buddy->trangthai_id == 19) {
                $this->buddy->update([
                    "trangthai_id" => 21
                ]);
            }
        } catch (\Illuminate\Database\QueryException $e) {
            $this->dispatchBrowserEvent('unblockUI');
            $this->dispatchBrowserEvent('toastr', ['type' => 'warning', 'title' => "Thất bại", 'message' => implode(" - ", $e->errorInfo)]);
            return null;
        } catch (\Exception $e2) {
            $this->dispatchBrowserEvent('unblockUI');
            $this->dispatchBrowserEvent('toastr', ['type' => 'warning', 'title' => "Thất bại", 'message' => $e2->getMessage()]);
            return null;
        }

        $this->buddy_tieuchies = Buddy::find($this->buddy->id)->buddy_tieuchies;

        $toastr_message = $this->toastr_message;
        $this->dispatchBrowserEvent('toastr', ['type' => 'success', 'title' => "Thành công", 'message' => $toastr_message]);

        $this->back_baocao_buddy();
    }

    public function done_tieuchi_buddy(BuddyTieuChi $tieuchi)
    {
        $this->buddy_tieuchi = $tieuchi;

        $this->doneTieuChiStatus = true;
        $this->baocaoStatus = false;
        $this->modal_title = "Hoàn thành Tiêu chí Buddy";
        $this->toastr_message = "Thành công";

        $this->dispatchBrowserEvent('unblockUI');
        $this->dispatchBrowserEvent('dynamic_update');
    }

    public function done_tieuchi_buddy_save()
    {
        if ($this->buddy->trangthai_id != 19 && $this->buddy->trangthai_id != 21) {
            $this->dispatchBrowserEvent('unblockUI');
            $this->dispatchBrowserEvent('toastr', ['type' => 'warning', 'title' => "Thất bại", 'message' => "Buddy này đang ở trạng thái không thể hoàn thành tiêu chí"]);
            return null;
        }

        if ($this->buddy->hr_key != $this->hr->key) {
            $this->dispatchBrowserEvent('unblockUI');
            $this->dispatchBrowserEvent('toastr', ['type' => 'warning', 'title' => "Thất bại", 'message' => "Bạn không phải là người đăng ký Buddy này"]);
            return null;
        }

        try {
            $this->buddy_tieuchi->update([
                "lock" => true
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

        $this->buddy_tieuchies = Buddy::find($this->buddy->id)->buddy_tieuchies;

        if ($this->check_buddy_baocao()) {
            $this->buddy->update([
                "trangthai_id" => 23
            ]);  

            $this->cancel();

            $this->dispatchBrowserEvent('toastr', ['type' => 'success', 'title' => "Thành công", 'message' => "Báo cáo thành công, Buddy đã thực hiện"]);
        } else {
            $toastr_message = $this->toastr_message;
            $this->dispatchBrowserEvent('toastr', ['type' => 'success', 'title' => "Thành công", 'message' => $toastr_message]);
            $this->back_baocao_buddy();
        }

    }

    public function check_buddy_baocao()
    {
        $done = true;
        foreach ($this->buddy_tieuchies as $buddy_tieuchi) {
            if (!!!$buddy_tieuchi->lock) {
                $done = false;
            }
        }

        return $done;
    }
}
