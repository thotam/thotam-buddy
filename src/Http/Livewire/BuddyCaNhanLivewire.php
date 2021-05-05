<?php

namespace Thotam\ThotamBuddy\Http\Livewire;

use Auth;
use Livewire\Component;
use Thotam\ThotamHr\Models\HR;
use Thotam\ThotamTeam\Models\Nhom;
use Thotam\ThotamBuddy\Models\Buddy;
use Thotam\ThotamBuddy\Traits\BuddyTraits;
use Thotam\ThotamBuddy\Models\BuddyTieuChi;

class BuddyCaNhanLivewire extends Component
{
    use BuddyTraits;

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
    protected $listeners = ['dynamic_update_method', 'add_buddy', 'edit_buddy', 'delete_buddy', 'len_tieuchi_buddy'];

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
        if ($this->hr->cannot("add-buddy")) {
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
}
