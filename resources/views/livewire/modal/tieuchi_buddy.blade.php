<div wire:ignore.self class="modal fade" id="tieuchi_buddy_modal" tabindex="-1" role="dialog" aria-labelledby="tieuchi_buddy_modal" aria-hidden="true" data-toggle="modal" data-backdrop="static" data-keyboard="false">

    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content py-2">
            <div class="modal-header">
                <h4 class="modal-title text-orange"><span class="fas fa-user-friends mr-3"></span>{{ $modal_title }}</h4>
                <button type="button" wire:click.prevent="cancel()" thotam-blockui class="close" data-dismiss="modal" wire:loading.attr="disabled" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            @if ($lenTieuChiStatus)
                <div class="modal-body">
                    <div class="container-fluid mx-0 px-0">
                        <form>
                            <div class="row">

                                @include('thotam-buddy::livewire.modal.details.basic_info')

                                @include('thotam-buddy::livewire.modal.details.duyet_info')

                                @include('thotam-buddy::livewire.modal.details.tieuchi_info')

                                @if ($buddy->trangthai_id == 13 && Str::contains(get_class($this), 'BuddyNhomLivewire'))
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="col-form-label text-indigo" for="duyet_tieuchi_ghichu">Ghi chú:</label>
                                        <div>
                                            <textarea class="form-control px-2" id="duyet_tieuchi_ghichu" wire:model.lazy="duyet_tieuchi_ghichu" placeholder="Các thông tin khác của người duyệt nếu có ..." autocomplete="off" style="width: 100%"></textarea>
                                        </div>
                                        @error('duyet_tieuchi_ghichu')
                                            <label class="pl-1 small invalid-feedback d-inline-block" ><i class="fas mr-1 fa-exclamation-circle"></i>{{ $message }}</label>
                                        @enderror
                                    </div>
                                </div>
                                @endif

                            </div>
                        </form>
                    </div>
                </div>

                <div class="modal-footer mx-auto">
                    <button wire:click.prevent="cancel()" thotam-blockui class="btn btn-danger" wire:loading.attr="disabled" data-dismiss="modal">Đóng</button>
                    @if (($buddy->trangthai_id == 9 || $buddy->trangthai_id == 11) && Str::contains(get_class($this), 'BuddyCaNhanLivewire'))
                        <button wire:click.prevent="lock_tieuchi_buddy()" thotam-blockui class="btn btn-success" wire:loading.attr="disabled">Chốt</button>
                        <button wire:click.prevent="add_tieuchi_buddy()" thotam-blockui class="btn btn-info" wire:loading.attr="disabled">Thêm</button>
                    @endif

                    @if ($buddy->trangthai_id == 13 && Str::contains(get_class($this), 'BuddyNhomLivewire'))
                        <button wire:click.prevent="duyet_tieuchi_buddy(15)" thotam-blockui class="btn btn-warning" wire:loading.attr="disabled">Không duyệt</button>
                        <button wire:click.prevent="duyet_tieuchi_buddy(19)" thotam-blockui class="btn btn-success" wire:loading.attr="disabled">Duyệt</button>
                    @endif
                </div>
            @endif

            @if ($addTieuChiStatus || $editTieuChiStatus)
                <div class="modal-body">
                    <div class="container-fluid mx-0 px-0">
                        <form>
                            <div class="row">

                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="col-form-label text-indigo" for="tentieuchi">Tên tiêu chí:</label>
                                        <div id="tentieuchi_div">
                                            <input type="text" class="form-control px-2" wire:model.lazy="tentieuchi" id="tentieuchi" style="width: 100%" placeholder="Tên tiêu chí ..." autocomplete="off">
                                        </div>
                                        @error('tentieuchi')
                                            <label class="pl-1 small invalid-feedback d-inline-block" ><i class="fas mr-1 fa-exclamation-circle"></i>{{ $message }}</label>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="col-form-label text-indigo" for="noidung">Nội dung tiêu chí:</label>
                                        <div>
                                            <textarea class="form-control px-2" id="noidung" wire:model.lazy="noidung" placeholder="Mô tả chi tiết nội dung tiêu chí..." autocomplete="off" style="width: 100%"></textarea>
                                        </div>
                                        @error('noidung')
                                            <label class="pl-1 small invalid-feedback d-inline-block" ><i class="fas mr-1 fa-exclamation-circle"></i>{{ $message }}</label>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-8 col-12">
                                    <div class="form-group">
                                        <label class="col-form-label text-indigo" for="ketqua_candat">Kết quả cần đạt:</label>
                                        <div id="ketqua_candat_div">
                                            <input type="text" class="form-control px-2" wire:model.lazy="ketqua_candat" id="ketqua_candat" style="width: 100%" placeholder="Mục tiêu/Kết quả cần đạt ..." autocomplete="off">
                                        </div>
                                        @error('ketqua_candat')
                                            <label class="pl-1 small invalid-feedback d-inline-block" ><i class="fas mr-1 fa-exclamation-circle"></i>{{ $message }}</label>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label class="col-form-label text-indigo" for="deadline">Deadline:</label>
                                        <div id="deadline_div">
                                            <input type="text" class="form-control px-2 thotam-datepicker" thotam-startview="0" thotam-container="deadline_div" wire:model="deadline" id="deadline" style="width: 100%" placeholder="Thời hạn thực hiện (Deadline) ..." readonly autocomplete="off">
                                        </div>
                                        @error('deadline')
                                            <label class="pl-1 small invalid-feedback d-inline-block" ><i class="fas mr-1 fa-exclamation-circle"></i>{{ $message }}</label>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="col-form-label text-indigo" for="len_tieuchi_ghichu">Ghi chú:</label>
                                        <div>
                                            <textarea class="form-control px-2" id="len_tieuchi_ghichu" wire:model.lazy="len_tieuchi_ghichu" placeholder="Các thông tin khác (nếu có)..." autocomplete="off" style="width: 100%"></textarea>
                                        </div>
                                        @error('len_tieuchi_ghichu')
                                            <label class="pl-1 small invalid-feedback d-inline-block" ><i class="fas mr-1 fa-exclamation-circle"></i>{{ $message }}</label>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>

                <div class="modal-footer mx-auto">
                    <button wire:click.prevent="back_tieuchi_buddy()" thotam-blockui class="btn btn-danger" wire:loading.attr="disabled">Trở lại</button>
                    <button wire:click.prevent="add_tieuchi_buddy_save()" thotam-blockui class="btn btn-success" wire:loading.attr="disabled">Xác nhận</button>
                </div>
            @endif

            @if ($deleteTieuChiStatus)
                <div class="modal-body">
                    <div class="container-fluid mx-0 px-0">
                        <form>
                            <div class="row">

                                <div class="col-12 mb-3 text-danger font-weight-semibold">
                                    Bạn sẽ xóa Tiêu chí Buddy có thông tin như sau, việc xóa là KHÔNG THỂ khôi phục,bạn có chắc chắn?
                                </div>

                                @if (!!$buddy_tieuchi)
                                    <div class="col-md-12 col-12 mt-1">
                                        <div class="form-group">
                                            <label class="col-form-label">Tên tiêu chí</label>
                                            <div>
                                                <span type="text" class="form-control px-2 h-auto">{{ $buddy_tieuchi->tentieuchi }}</span>
                                            </div>
                                        </div>
                                    </div>
                    
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label class="col-form-label">Nội dung:</label>
                                            <div>
                                                <pre class="form-control px-2 h-auto thotam-pre">{{ $buddy_tieuchi->noidung }}</pre>
                                            </div>
                                        </div>
                                    </div>
                    
                                    <div class="col-md-8 col-12">
                                        <div class="form-group">
                                            <label class="col-form-label">Kết quả cần đạt:</label>
                                            <div>
                                                <pre class="form-control px-2 h-auto thotam-pre">{{ $buddy_tieuchi->ketqua_candat }}</pre>
                                            </div>
                                        </div>
                                    </div>
                    
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label class="col-form-label">Deadline:</label>
                                            <div>
                                                <pre class="form-control px-2 h-auto thotam-pre">{{ $buddy_tieuchi->deadline->format('d-m-Y') }}</pre>
                                            </div>
                                        </div>
                                    </div>
                    
                                    @if (!!$buddy_tieuchi->ghichu )
                                        <div class="col-md-12 col-12">
                                            <div class="form-group">
                                                <label class="col-form-label">Ghi chú:</label>
                                                <div>
                                                    <pre class="form-control px-2 h-auto thotam-pre">{{ $buddy_tieuchi->ghichu }}</pre>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label class="col-form-label">Người tạo tiêu chí:</label>
                                            <div>
                                                <pre class="form-control px-2 h-auto thotam-pre">{{ $buddy_tieuchi->hr->hoten }}</pre>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label class="col-form-label">Thời gian tạo tiêu chí:</label>
                                            <div>
                                                <pre class="form-control px-2 h-auto thotam-pre">{{ $buddy_tieuchi->created_at->format("d-m-Y H:i:s") }}</pre>
                                            </div>
                                        </div>
                                    </div>

                                @endif


                            </div>
                        </form>
                    </div>
                </div>

                <div class="modal-footer mx-auto">
                    <button wire:click.prevent="back_tieuchi_buddy()" thotam-blockui class="btn btn-info" wire:loading.attr="disabled">Trở lại</button>
                    <button wire:click.prevent="delete_tieuchi_buddy_action()" thotam-blockui class="btn btn-danger" wire:loading.attr="disabled">Xóa</button>
                </div>
            @endif

            @if ($chotTieuChiStatus)
                <div class="modal-body">
                    <div class="container-fluid mx-0 px-0">
                        <form>
                            <div class="row">

                                <div class="col-12 mb-3 text-danger font-weight-semibold">
                                    Các tiêu chí Buddy sau khi chốt sẽ KHÔNG THỂ thêm, chỉnh sửa hoặc xóa,bạn có chắc chắn?
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
                
                <div class="modal-footer mx-auto">
                    <button wire:click.prevent="back_tieuchi_buddy()" thotam-blockui class="btn btn-danger" wire:loading.attr="disabled">Trở lại</button>
                    <button wire:click.prevent="lock_tieuchi_buddy_action()" thotam-blockui class="btn btn-success" wire:loading.attr="disabled">Chốt</button>
                </div>
            @endif

        </div>
    </div>

</div>
