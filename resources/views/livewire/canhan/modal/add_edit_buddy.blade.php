<div wire:ignore.self class="modal fade" id="add_edit_buddy_modal" tabindex="-1" role="dialog" aria-labelledby="add_edit_buddy_modal" aria-hidden="true" data-toggle="modal" data-backdrop="static" data-keyboard="false">

    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content py-2">
            <div class="modal-header">
                <h4 class="modal-title text-purple"><span class="fas fa-user-friends mr-3"></span>{{ $modal_title }}</h4>
                <button type="button" wire:click.prevent="cancel()" thotam-blockui class="close" data-dismiss="modal" wire:loading.attr="disabled" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            @if ($addStatus || $editStatus)
                <div class="modal-body">
                    <div class="container-fluid mx-0 px-0">
                        <form>
                            <div class="row">

                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Mã nhân sự:</label>
                                        <div>
                                            <span type="text" class="form-control px-2 h-auto">{{ $hr_key }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-8 col-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Họ và tên:</label>
                                        <div>
                                            <span type="text" class="form-control px-2 h-auto">{{ $hoten }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="col-form-label text-indigo" for="email">Email của bạn:</label>
                                        <div id="email_div">
                                            <input type="email" class="form-control px-2" wire:model.lazy="email" id="email" style="width: 100%" placeholder="Email của bạn ..." autocomplete="off">
                                        </div>
                                        @error('email')
                                            <label class="pl-1 small invalid-feedback d-inline-block" ><i class="fas mr-1 fa-exclamation-circle"></i>{{ $message }}</label>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label class="col-form-label text-indigo" for="nhom_id">Nhóm/Bộ phận:</label>
                                        <div class="select2-success" id="nhom_id_div">
                                            <select class="form-control px-2 thotam-select2" thotam-placeholder="Nhóm/Bộ phận ..." thotam-search="10" wire:model="nhom_id" id="nhom_id" style="width: 100%">
                                                @if (!!count($nhom_arrays))
                                                    <option selected></option>
                                                    @foreach ($nhom_arrays as $id => $full_name)
                                                        <option value="{{ $id }}">{{ $full_name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        @error('nhom_id')
                                            <label class="pl-1 small invalid-feedback d-inline-block" ><i class="fas mr-1 fa-exclamation-circle"></i>{{ $message }}</label>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label class="col-form-label text-indigo" for="quanly_hr_key">Quản lý của bạn:</label>
                                        <div class="select2-success" id="quanly_hr_key_div">
                                            <select class="form-control px-2 thotam-select2" thotam-placeholder="Quản lý của bạn ..." thotam-search="10" wire:model="quanly_hr_key" id="quanly_hr_key" style="width: 100%">
                                                @if (!!count($quanly_arrays))
                                                    <option selected></option>
                                                    @foreach ($quanly_arrays as $key => $hoten)
                                                        <option value="{{ $key }}">{{ $hoten }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        @error('quanly_hr_key')
                                            <label class="pl-1 small invalid-feedback d-inline-block" ><i class="fas mr-1 fa-exclamation-circle"></i>{{ $message }}</label>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="col-form-label text-indigo" for="quanly_email">Email quản lý của bạn:</label>
                                        <div id="quanly_email_div">
                                            <input type="email" class="form-control px-2" wire:model.lazy="quanly_email" id="quanly_email" style="width: 100%" placeholder="Email quản lý của bạn ..." autocomplete="off">
                                        </div>
                                        @error('quanly_email')
                                            <label class="pl-1 small invalid-feedback d-inline-block" ><i class="fas mr-1 fa-exclamation-circle"></i>{{ $message }}</label>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="col-form-label text-indigo" for="nhucau">Nhu cầu đào tạo:</label>
                                        <div>
                                            <textarea class="form-control px-2" id="nhucau" wire:model.lazy="nhucau" placeholder="Tóm gọn nhu cầu đào tạo của bạn..." autocomplete="off" style="width: 100%"></textarea>
                                        </div>
                                        @error('nhucau')
                                            <label class="pl-1 small invalid-feedback d-inline-block" ><i class="fas mr-1 fa-exclamation-circle"></i>{{ $message }}</label>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="col-form-label text-indigo" for="ghichu">Ghi chú:</label>
                                        <div>
                                            <textarea class="form-control px-2" id="ghichu" wire:model.lazy="ghichu" placeholder="Các thông tin khác (nếu có)..." autocomplete="off" style="width: 100%"></textarea>
                                        </div>
                                        @error('ghichu')
                                            <label class="pl-1 small invalid-feedback d-inline-block" ><i class="fas mr-1 fa-exclamation-circle"></i>{{ $message }}</label>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            @endif

            <div class="modal-footer mx-auto">
                <button wire:click.prevent="cancel()" thotam-blockui class="btn btn-danger" wire:loading.attr="disabled" data-dismiss="modal">Đóng</button>
                <button wire:click.prevent="save_buddy()" thotam-blockui class="btn btn-success" wire:loading.attr="disabled">Xác nhận</button>
            </div>

        </div>
    </div>

</div>
