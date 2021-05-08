<div wire:ignore.self class="modal fade" id="baocao_buddy_modal" tabindex="-1" role="dialog" aria-labelledby="baocao_buddy_modal" aria-hidden="true" data-toggle="modal" data-backdrop="static" data-keyboard="false">

    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content py-2">
            <div class="modal-header">
                <h4 class="modal-title text-purple"><span class="fas fa-user-friends mr-3"></span>{{ $modal_title }}</h4>
                <button type="button" wire:click.prevent="cancel()" thotam-blockui class="close" data-dismiss="modal" wire:loading.attr="disabled" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            @if ($baocaoStatus)
                <div class="modal-body">
                    <div class="container-fluid mx-0 px-0">
                        <form>
                            <div class="row">

                                <div class="col-md-3 col-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Mã Buddy:</label>
                                        <div>
                                            <span type="text" class="form-control px-2 h-auto">{{ $buddy->buddy_code }}</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-3 col-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Mã nhân sự:</label>
                                        <div>
                                            <span type="text" class="form-control px-2 h-auto">{{ $buddy->hr->key }}</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Họ và tên:</label>
                                        <div>
                                            <span type="text" class="form-control px-2 h-auto">{{ $buddy->hr->hoten }}</span>
                                        </div>
                                    </div>
                                </div>

                                @if (count($buddy_tieuchies) != 0)
                                    @include('thotam-buddy::livewire.modal.details.tieuchi_info')
                                @endif

                            </div>
                        </form>
                    </div>
                </div>

                
                <div class="modal-footer mx-auto">
                    <button wire:click.prevent="cancel()" thotam-blockui class="btn btn-danger" wire:loading.attr="disabled" data-dismiss="modal">Đóng</button>
                </div>

            @endif

            @if ($baoCaoTieuChiStatus)
                <div class="modal-body">
                    <div class="container-fluid mx-0 px-0">
                        <form>
                            <div class="row">

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

                                    @if (count($buddy_tieuchi->baocaos) != 0)
                                        <div class="col-12">
                                            <div class="form-group mb-1 mt-1 text-success">
                                                <b>Thông tin báo cáo:</b>
                                            </div>
                                        
                                            <div class="row px-3">
                                                @foreach ($buddy_tieuchi->baocaos as $baocao)
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group">
                                                            <label class="col-form-label text-success">Báo cáo {{ $loop->index +1 }} - Kết quả:</label>
                                                            <div>
                                                                <span class="form-control px-2 h-auto">@if($baocao->ketqua) Hoàn thành @else Không hoàn thành @endif</span>
                                                            </div>
                                                        </div>
                                                    </div>
                    
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group">
                                                            <label class="col-form-label">Thời gian hoàn thành:</label>
                                                            <div>
                                                                <span class="form-control px-2 h-auto">{{ $baocao->thoigian->format('d-m-Y') }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                    
                                                    <div class="col-md-12 col-12">
                                                        <div class="form-group">
                                                            <label class="col-form-label">Chi tiết công việc đã thực hiện:</label>
                                                            <div>
                                                                <span class="form-control px-2 h-auto">{{ $baocao->noidung }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                    
                                                    @if (!!$baocao->ghichu)
                                                        <div class="col-md-12 col-12">
                                                            <div class="form-group">
                                                                <label class="col-form-label">Ghi chú:</label>
                                                                <div>
                                                                    <span class="form-control px-2 h-auto">{{ $baocao->ghichu }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                    
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label class="col-form-label text-indigo" for="baocao_ketqua">Kết quả:</label>
                                            <div class="select2-success" id="baocao_ketqua_div">
                                                <select class="form-control px-2 thotam-select2" thotam-placeholder="Kết quả thực hiện ..." thotam-search="10" wire:model="baocao_ketqua" id="baocao_ketqua" style="width: 100%">
                                                    <option selected></option>
                                                    <option value="1">Hoàn thành</option>
                                                    <option value="0">Không hoàn thành</option>
                                                </select>
                                            </div>
                                            @error('baocao_ketqua')
                                                <label class="pl-1 small invalid-feedback d-inline-block" ><i class="fas mr-1 fa-exclamation-circle"></i>{{ $message }}</label>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label class="col-form-label text-indigo" for="baocao_thoigian">Thời gian hoàn thành:</label>
                                            <div id="baocao_thoigian_div">
                                                <input type="text" class="form-control px-2 thotam-datepicker" thotam-startview="0" thotam-container="baocao_thoigian_div" wire:model="baocao_thoigian" id="baocao_thoigian" style="width: 100%" placeholder="Thời gian kết thúc công việc ..." readonly autocomplete="off">
                                            </div>
                                            @error('baocao_thoigian')
                                                <label class="pl-1 small invalid-feedback d-inline-block" ><i class="fas mr-1 fa-exclamation-circle"></i>{{ $message }}</label>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="col-form-label text-indigo" for="baocao_noidung">Chi tiết công việc đã thực hiện:</label>
                                            <div>
                                                <textarea class="form-control px-2" id="baocao_noidung" wire:model.lazy="baocao_noidung" placeholder="Chi tiết công việc đã thực hiện của bạn..." autocomplete="off" style="width: 100%"></textarea>
                                            </div>
                                            @error('baocao_noidung')
                                                <label class="pl-1 small invalid-feedback d-inline-block" ><i class="fas mr-1 fa-exclamation-circle"></i>{{ $message }}</label>
                                            @enderror
                                        </div>
                                    </div>
    
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="col-form-label text-indigo" for="baocao_ghichu">Ghi chú:</label>
                                            <div>
                                                <textarea class="form-control px-2" id="baocao_ghichu" wire:model.lazy="baocao_ghichu" placeholder="Các thông tin khác (nếu có)..." autocomplete="off" style="width: 100%"></textarea>
                                            </div>
                                            @error('baocao_ghichu')
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
                    <button wire:click.prevent="back_baocao_buddy()" thotam-blockui class="btn btn-danger" wire:loading.attr="disabled">Trở lại</button>
                    <button wire:click.prevent="baocao_tieuchi_buddy_save()" thotam-blockui class="btn btn-success" wire:loading.attr="disabled">Xác nhận</button>
                </div>
            @endif

            @if ($doneTieuChiStatus)
                <div class="modal-body">
                    <div class="container-fluid mx-0 px-0">
                        <form>
                            <div class="row">

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

                                    @if (count($buddy_tieuchi->baocaos) != 0)
                                        <div class="col-12">
                                            <div class="form-group mb-1 mt-1 text-success">
                                                <b>Thông tin báo cáo:</b>
                                            </div>
                                        
                                            <div class="row px-3">
                                                @foreach ($buddy_tieuchi->baocaos as $baocao)
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group">
                                                            <label class="col-form-label text-success">Báo cáo {{ $loop->index +1 }} - Kết quả:</label>
                                                            <div>
                                                                <span class="form-control px-2 h-auto">@if($baocao->ketqua) Hoàn thành @else Không hoàn thành @endif</span>
                                                            </div>
                                                        </div>
                                                    </div>
                    
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group">
                                                            <label class="col-form-label">Thời gian hoàn thành:</label>
                                                            <div>
                                                                <span class="form-control px-2 h-auto">{{ $baocao->thoigian->format('d-m-Y') }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                    
                                                    <div class="col-md-12 col-12">
                                                        <div class="form-group">
                                                            <label class="col-form-label">Chi tiết công việc đã thực hiện:</label>
                                                            <div>
                                                                <span class="form-control px-2 h-auto">{{ $baocao->noidung }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                    
                                                    @if (!!$baocao->ghichu)
                                                        <div class="col-md-12 col-12">
                                                            <div class="form-group">
                                                                <label class="col-form-label">Ghi chú:</label>
                                                                <div>
                                                                    <span class="form-control px-2 h-auto">{{ $baocao->ghichu }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                    
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    <div class="col-12 mb-3 text-danger font-weight-semibold">
                                        Việc xác nhận đồng nghĩa với việc bạn sẽ hoàn tất báo cáo của tiêu chí này, bạn chỉ nên ấn khi đã hoàn thành toàn bộ các gian đoạn của tiêu chí,bạn có chắc chắn?
                                    </div>

                                @endif

                            </div>
                        </form>
                    </div>
                </div>

                <div class="modal-footer mx-auto">
                    <button wire:click.prevent="back_baocao_buddy()" thotam-blockui class="btn btn-danger" wire:loading.attr="disabled">Trở lại</button>
                    <button wire:click.prevent="done_tieuchi_buddy_save()" thotam-blockui class="btn btn-success" wire:loading.attr="disabled">Xác nhận</button>
                </div>
            @endif

        </div>
    </div>

</div>
