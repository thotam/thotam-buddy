<?php

namespace Thotam\ThotamBuddy\Http\Livewire;

use Auth;
use Livewire\Component;
use Thotam\ThotamHr\Models\HR;
use Thotam\ThotamTeam\Models\Nhom;
use Thotam\ThotamBuddy\Models\Buddy;
use Thotam\ThotamPlus\Traits\ThoTamRandomCodeTrait;

class BuddyCaNhanLivewire extends Component
{
    use ThoTamRandomCodeTrait;

    /**
    * Các biến sử dụng trong Component
    *
    * @var mixed
    */
    public $buddy, $buddy_id, $buddy_code, $nhom_id, $quanly_hr_key, $nhucau, $ghichu, $hr_key, $email, $quanly_email, $hoten;
    public $nhom_arrays = [], $quanly_arrays = [];
    public $hr;
    public $modal_title, $toastr_message;

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
    protected $listeners = ['dynamic_update_method', 'add_buddy', 'edit_buddy',];

    /**
     * dynamic_update_method
     *
     * @return void
     */
    public function dynamic_update_method()
    {
        $this->dispatchBrowserEvent('dynamic_update');
    }


    /**
     * On updated action
     *
     * @param  mixed $propertyName
     * @return void
     */
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

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
        $this->resetValidation();
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
    }

    public function updatedNhomId()
    {
        $this->quanly_arrays = Nhom::find($this->nhom_id)->nhom_has_quanlys->pluck("hoten", "key");
        $quanly_arrays = Nhom::find($this->nhom_id)->nhom_has_quanlys;
        if (count($this->quanly_arrays) == 1) {
            $this->quanly_hr_key = $quanly_arrays->first()->key;
            $this->updatedQuanlyHrKey();
        } else {
            $this->quanly_hr_key = null;
            $this->quanly_email = null;
        }
    }

    public function updatedQuanlyHrKey()
    {
        $this->quanly_email = HR::find($this->quanly_hr_key)->getMail("buddy");

        if (!!$this->quanly_email) {
            $this->validateOnly("quanly_email");
        }
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
    
    /**
     * save_buddy
     *
     * @return void
     */
    public function save_buddy()
    {
        if ($this->hr->cannot("add-buddy") && $this->hr->cannot("edit-buddy")) {
            $this->dispatchBrowserEvent('unblockUI');
            $this->dispatchBrowserEvent('toastr', ['type' => 'warning', 'title' => "Thất bại", 'message' => "Bạn không có quyền thực hiện hành động này"]);
            return null;
        }

        $this->dispatchBrowserEvent('unblockUI');
        $this->validate([
            'nhom_id' => 'required|exists:nhoms,id',
            'quanly_hr_key' => 'required|exists:hrs,key',
            'email' => 'required|email',
            'quanly_email' => 'required|email',
            'nhucau' => 'required|string',
            'ghichu' => 'nullable|string',
        ]);
        $this->dispatchBrowserEvent('blockUI');

        try {
            HR::find($this->quanly_hr_key)->checkAndGetMail($this->quanly_email,"buddy");
            HR::find($this->hr_key)->checkAndGetMail($this->email,"buddy");
            $this->buddy = Buddy::updateOrCreate(
                ['id' => $this->buddy_id],
                [
                    "nhom_id" => $this->nhom_id,
                    "quanly_hr_key" => $this->quanly_hr_key,
                    "hr_key" => $this->hr_key,
                    "nhucau" => $this->nhucau,
                    "ghichu" => $this->ghichu,
                ]
            );

            if (!!!$this->buddy->buddy_code) {
                $this->buddy->update([
                    "buddy_code" => "BD".sprintf("%03d",$this->buddy->id % 1000).$this->get_random_code(5),
                    'active' => true,
                ]);
            }

            if (!!!$this->buddy->trangthai_id) {
                $this->buddy->update(["trangthai_id" => 5]);
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

        //Đẩy thông tin về trình duyệt
        $this->dispatchBrowserEvent('dt_draw');
        $toastr_message = $this->toastr_message;
        $this->cancel();
        $this->dispatchBrowserEvent('toastr', ['type' => 'success', 'title' => "Thành công", 'message' => $toastr_message]);
    }
}
