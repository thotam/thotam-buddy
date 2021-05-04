<?php

namespace Thotam\ThotamBuddy\Traits;

use Thotam\ThotamHr\Models\HR;
use Thotam\ThotamTeam\Models\Nhom;
use Thotam\ThotamBuddy\Models\Buddy;
use Thotam\ThotamPlus\Traits\ThoTamRandomCodeTrait;

trait BuddyTraits
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
     * edit_buddy
     *
     * @param  mixed $buddy
     * @return void
     */
    public function edit_buddy(Buddy $buddy)
    {
        if ($this->hr->cannot("edit-buddy")) {
            $this->dispatchBrowserEvent('toastr', ['type' => 'warning', 'title' => "Thất bại", 'message' => "Bạn không có quyền thực hiện hành động này"]);
            $this->cancel();
            return null;
        }

        $this->buddy = $buddy;

        if ($this->buddy->trangthai_id !== 5) {
            $this->dispatchBrowserEvent('toastr', ['type' => 'warning', 'title' => "Thất bại", 'message' => "Chỉ Buddy ở trạng thái Mới tạo mới có thể chỉnh sửa"]);
            $this->cancel();
            return null;
        }

        if ($this->buddy->hr_key !== $this->hr->key) {
            $this->dispatchBrowserEvent('toastr', ['type' => 'warning', 'title' => "Thất bại", 'message' => "Chỉ người đăng ký, quản lý của người đăng ký hoặc Admin mới có quyền sửa Buddy này"]);
            $this->cancel();
            return null;
        }

        $this->editStatus = true;
        $this->modal_title = "Chỉnh sửa Buddy";
        $this->toastr_message = "Chỉnh sửa Buddy thành công";

        $this->hr_key = $this->buddy->hr_key;
        $this->hoten = $this->buddy->hr->hoten;
        $this->nhom_id = $this->buddy->nhom_id;
        $this->quanly_hr_key = $this->buddy->quanly_hr_key;
        $this->nhucau = $this->buddy->nhucau;
        $this->ghichu = $this->buddy->ghichu;

        $this->email = HR::find($this->hr_key)->getMail("buddy");
        $this->quanly_email = HR::find($this->quanly_hr_key)->getMail("buddy");
        $this->quanly_arrays = Nhom::find($this->nhom_id)->nhom_has_quanlys->pluck("hoten", "key");

        $nhom_arrays = HR::find($this->hr_key)->quanly_of_nhoms;
        $nhom_arrays = $nhom_arrays->merge(HR::find($this->hr_key)->thanhvien_of_nhoms);
        $this->nhom_arrays = $nhom_arrays->pluck("full_name", "id");

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

        if ($this->editStatus) {
            if ($this->buddy->trangthai_id !== 5) {
                $this->dispatchBrowserEvent('unblockUI');
                $this->dispatchBrowserEvent('toastr', ['type' => 'warning', 'title' => "Thất bại", 'message' => "Chỉ Buddy ở trạng thái Mới tạo mới có thể chỉnh sửa"]);
                return null;
            }

            if ($this->buddy->hr_key !== $this->hr->key) {
                $this->dispatchBrowserEvent('unblockUI');
                $this->dispatchBrowserEvent('toastr', ['type' => 'warning', 'title' => "Thất bại", 'message' => "Chỉ người đăng ký, quản lý của người đăng ký hoặc Admin mới có quyền sửa Buddy này"]);
                return null;
            }
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

    /**
     * delete_buddy
     *
     * @param  mixed $buddy
     * @return void
     */
    public function delete_buddy(Buddy $buddy)
    {
        $this->buddy = $buddy;

        if ($this->buddy->trangthai_id !== 5) {
            $this->dispatchBrowserEvent('toastr', ['type' => 'warning', 'title' => "Thất bại", 'message' => "Chỉ Buddy ở trạng thái Mới tạo mới có thể xóa"]);
            $this->cancel();
            return null;
        }

        if ($this->buddy->hr_key !== $this->hr->key) {
            $this->dispatchBrowserEvent('toastr', ['type' => 'warning', 'title' => "Thất bại", 'message' => "Chỉ người đăng ký, quản lý của người đăng ký hoặc Admin mới có quyền xóa Buddy này"]);
            $this->cancel();
            return null;
        }

        $this->deleteStatus = true;
        $this->modal_title = "Xóa Buddy";
        $this->toastr_message = "Xóa Buddy thành công";

        $this->dispatchBrowserEvent('unblockUI');
        $this->dispatchBrowserEvent('dynamic_update');
        $this->dispatchBrowserEvent('show_modal', "#delete_buddy_modal");
    }
    
    /**
     * delete_buddy_action
     *
     * @return void
     */
    public function delete_buddy_action()
    {
        if ($this->buddy->trangthai_id !== 5) {
            $this->dispatchBrowserEvent('unblockUI');
            $this->dispatchBrowserEvent('toastr', ['type' => 'warning', 'title' => "Thất bại", 'message' => "Chỉ Buddy ở trạng thái Mới tạo mới có thể xóa"]);
            return null;
        }

        if ($this->buddy->hr_key !== $this->hr->key) {
            $this->dispatchBrowserEvent('unblockUI');
            $this->dispatchBrowserEvent('toastr', ['type' => 'warning', 'title' => "Thất bại", 'message' => "Chỉ người đăng ký, quản lý của người đăng ký hoặc Admin mới có quyền xóa Buddy này"]);
            return null;
        }

        try {
            $this->buddy->update(["trangthai_id" => 1]);
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
