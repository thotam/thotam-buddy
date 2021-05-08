<div wire:ignore.self class="modal fade" id="danhgia_buddy_modal" tabindex="-1" role="dialog" aria-labelledby="danhgia_buddy_modal" aria-hidden="true" data-toggle="modal" data-backdrop="static" data-keyboard="false">

    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content py-2">
            <div class="modal-header">
                <h4 class="modal-title text-purple"><span class="fas fa-user-friends mr-3"></span>{{ $modal_title }}</h4>
                <button type="button" wire:click.prevent="cancel()" thotam-blockui class="close" data-dismiss="modal" wire:loading.attr="disabled" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            @if ($danhgiaStatus)
                <div class="modal-body">
                    <div class="container-fluid mx-0 px-0">
                        <form>
                            <div class="row">

                                @include('thotam-buddy::livewire.modal.details.basic_info')

                                @include('thotam-buddy::livewire.modal.details.duyet_info')

                                @if (count($buddy_tieuchies) != 0)
                                    @include('thotam-buddy::livewire.modal.details.tieuchi_info')
                                @endif

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label class="col-form-label text-indigo" for="danhgia_ketqua">Kết quả:</label>
                                        <div class="select2-success" id="danhgia_ketqua_div">
                                            <select class="form-control px-2 thotam-select2" thotam-placeholder="Kết quả thực hiện ..." thotam-search="10" wire:model="danhgia_ketqua" id="danhgia_ketqua" style="width: 100%">
                                                <option selected></option>
                                                <option value="27">Đạt</option>
                                                <option value="25">Không đạt</option>
                                            </select>
                                        </div>
                                        @error('danhgia_ketqua')
                                            <label class="pl-1 small invalid-feedback d-inline-block" ><i class="fas mr-1 fa-exclamation-circle"></i>{{ $message }}</label>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label class="col-form-label text-indigo" for="danhgia_thuongtien">Đề xuất thưởng tiền:</label>
                                        <div class="select2-success" id="danhgia_thuongtien_div">
                                            <select class="form-control px-2 thotam-select2" thotam-placeholder="Có đề xuất thưởng tiền hay không? ..." thotam-search="10" wire:model="danhgia_thuongtien" id="danhgia_thuongtien" style="width: 100%">
                                                <option selected></option>
                                                <option value="1">Có</option>
                                                <option value="0">Không</option>
                                            </select>
                                        </div>
                                        @error('danhgia_thuongtien')
                                            <label class="pl-1 small invalid-feedback d-inline-block" ><i class="fas mr-1 fa-exclamation-circle"></i>{{ $message }}</label>
                                        @enderror
                                    </div>
                                </div>


                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="col-form-label text-indigo" for="danhgia_noidung">Nội dung đánh giá:</label>
                                        <div>
                                            <textarea class="form-control px-2" id="danhgia_noidung" wire:model.lazy="danhgia_noidung" placeholder="Nội dung đánh giá ..." autocomplete="off" style="width: 100%"></textarea>
                                        </div>
                                        @error('danhgia_noidung')
                                            <label class="pl-1 small invalid-feedback d-inline-block" ><i class="fas mr-1 fa-exclamation-circle"></i>{{ $message }}</label>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="col-form-label text-indigo" for="danhgia_ghichu">Ghi chú:</label>
                                        <div>
                                            <textarea class="form-control px-2" id="danhgia_ghichu" wire:model.lazy="danhgia_ghichu" placeholder="Các thông tin khác (nếu có)..." autocomplete="off" style="width: 100%"></textarea>
                                        </div>
                                        @error('danhgia_ghichu')
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
                <button wire:click.prevent="save_danhgia_buddy()" thotam-blockui class="btn btn-success" wire:loading.attr="disabled">Xác nhận</button>
            </div>

        </div>
    </div>

</div>
