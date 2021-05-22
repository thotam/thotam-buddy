<div wire:ignore.self class="modal fade" id="duyet_buddy_modal" tabindex="-1" role="dialog" aria-labelledby="duyet_buddy_modal" aria-hidden="true" data-toggle="modal" data-backdrop="static" data-keyboard="false">

    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content py-2">
            <div class="modal-header">
                <h4 class="modal-title text-purple"><span class="fas fa-user-friends mr-3"></span>{{ $modal_title }}</h4>
                <button type="button" wire:click.prevent="cancel()" thotam-blockui class="close" data-dismiss="modal" wire:loading.attr="disabled" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            @if ($duyetStatus)
                <div class="modal-body">
                    <div class="container-fluid mx-0 px-0">
                        <form>
                            <div class="row">

                                @include('thotam-buddy::livewire.modal.details.basic_info')

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label class="col-form-label text-indigo" for="ngayvaolam">Ngày bắt đầu thử việc:</label>
                                        <div id="ngayvaolam_div">
                                            <input type="text" class="form-control px-2 thotam-datepicker" thotam-startview="3" thotam-container="ngayvaolam_div" wire:model="ngayvaolam" id="ngayvaolam" style="width: 100%" placeholder="Ngày thử việc (ngày bắt đầu thử việc) ..." readonly autocomplete="off">
                                        </div>
                                        @error('ngayvaolam')
                                            <label class="pl-1 small invalid-feedback d-inline-block" ><i class="fas mr-1 fa-exclamation-circle"></i>{{ $message }}</label>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label class="col-form-label text-indigo" for="duyet_ketqua">Phê duyệt:</label>
                                        <div class="select2-success" id="duyet_ketqua_div">
                                            <select class="form-control px-2 thotam-select2" thotam-placeholder="Phê duyệt Buddy..." thotam-search="10" wire:model="duyet_ketqua" id="duyet_ketqua" style="width: 100%">
                                                <option selected></option>
                                                <option value="9">Duyệt</option>
                                                <option value="7">Không duyệt</option>
                                            </select>
                                        </div>
                                        @error('duyet_ketqua')
                                            <label class="pl-1 small invalid-feedback d-inline-block" ><i class="fas mr-1 fa-exclamation-circle"></i>{{ $message }}</label>
                                        @enderror
                                    </div>
                                </div>

                                @if ($duyet_ketqua == 9)

                                {{--  <div class="col-12">
                                    <div class="form-group">
                                        <label class="col-form-label text-indigo" for="nguoihuongdan">Người hướng dẫn:</label>
                                        <div class="select2-success" id="nguoihuongdan_div">
                                            <select class="form-control px-2 thotam-select2-multi" multiple thotam-placeholder="Người hướng dẫn ..." thotam-search="10" wire:model="nguoihuongdan" id="nguoihuongdan" style="width: 100%">
                                                @if (!!count($nguoihuongdan_arrays))
                                                    <option selected></option>
                                                    @foreach ($nguoihuongdan_arrays as $key => $hoten)
                                                        <option value="{{ $key }}">[{{ $key }}] {{ $hoten }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        @error('nguoihuongdan')
                                            <label class="pl-1 small invalid-feedback d-inline-block" ><i class="fas mr-1 fa-exclamation-circle"></i>{{ $message }}</label>
                                        @enderror
                                    </div>
                                </div>  --}}

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="col-form-label text-indigo" for="nguoihuongdan">Người hướng dẫn:</label>
                                            <div class="select2-success" id="nguoihuongdan_div">
                                                <select class="form-control px-2 thotam-select2-multi" multiple thotam-placeholder="Người hướng dẫn ..." thotam-search="10" wire:model="nguoihuongdan" id="nguoihuongdan" style="width: 100%">
                                                    
                                                    @if (!!count($nhom_nguoihuongdan_arrays))
                                                        @foreach ($nhom_nguoihuongdan_arrays as $nhom)
                                                            <optgroup label="{{ $nhom['full_name'] }}">

                                                                @foreach ($nhom['nhom_has_quanlys'] as $quanly)
                                                                    <option value="{{ $quanly['key'] }}">[{{ $quanly['key'] }}] {{ $quanly['hoten'] }}</option>
                                                                @endforeach
        
                                                                @foreach ($nhom['nhom_has_thanhviens'] as $thanhvien)
                                                                    <option value="{{ $thanhvien['key'] }}">[{{ $thanhvien['key'] }}] {{ $thanhvien['hoten'] }}</option>
                                                                @endforeach
        
                                                            </optgroup>
                                                        @endforeach
                                                    @endif

                                                </select>
                                            </div>
                                            @error('nguoihuongdan')
                                                <label class="pl-1 small invalid-feedback d-inline-block" ><i class="fas mr-1 fa-exclamation-circle"></i>{{ $message }}</label>
                                            @enderror
                                        </div>
                                    </div>
                                @endif

                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="col-form-label text-indigo" for="duyet_ghichu">Ghi chú:</label>
                                        <div>
                                            <textarea class="form-control px-2" id="duyet_ghichu" wire:model.lazy="duyet_ghichu" placeholder="Các thông tin khác (nếu có)..." autocomplete="off" style="width: 100%"></textarea>
                                        </div>
                                        @error('duyet_ghichu')
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
                <button wire:click.prevent="save_duyet_buddy()" thotam-blockui class="btn btn-success" wire:loading.attr="disabled">Xác nhận</button>
            </div>

        </div>
    </div>

</div>
