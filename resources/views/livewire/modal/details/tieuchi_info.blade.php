<div class="col-12">
    <div class="form-group mb-1 mt-1 text-orange">
        <b>Danh sách tiêu chí:</b>
    </div>

    <div class="row px-3">
        @if (count($buddy_tieuchies) != 0)
            @foreach ($buddy_tieuchies as $buddy_tieuchi)
                <div class="col-md-12 col-12 mt-1">
                    <div class="form-group">
                        <label class="col-form-label text-orange">
                            Tiêu chí {{ $loop->index + 1}}:

                            @if (($lenTieuChiStatus && ($buddy->trangthai_id == 9 || $buddy->trangthai_id == 11)) || (Str::contains(get_class($this), 'BuddyNhomLivewire') && ($buddy->trangthai_id == 13)))
                                <i wire:key="edit_{{ $loop->index }}" thotam-blockui wire:click.prevent="edit_tieuchi_buddy({{ $buddy_tieuchi->id }})" class='action-icon text-twitter fas fa-edit ml-3'></i>
                                <i wire:key="trash_{{ $loop->index }}" thotam-blockui wire:click.prevent="delete_tieuchi_buddy({{ $buddy_tieuchi->id }})" class='action-icon text-danger fas fa-trash-alt ml-3'></i>
                            @endif

                            @if ($baocaoStatus && !!!$buddy_tieuchi->lock && ($buddy->trangthai_id == 19 || $buddy->trangthai_id == 21))
                                <i wire:key="baocao_{{ $loop->index }}" thotam-blockui wire:click.prevent="baocao_tieuchi_buddy({{ $buddy_tieuchi->id }})" class='action-icon text-success fas fa-file-upload ml-4'></i>
                                <i wire:key="done_{{ $loop->index }}" thotam-blockui wire:click.prevent="done_tieuchi_buddy({{ $buddy_tieuchi->id }})" class='action-icon text-indigo fas fa-check-double ml-4'></i>
                            @endif
                        </label>
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

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Người báo cáo:</label>
                                        <div>
                                            <pre class="form-control px-2 h-auto thotam-pre">{{ $baocao->hr->hoten }}</pre>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Thời gian báo cáo:</label>
                                        <div>
                                            <pre class="form-control px-2 h-auto thotam-pre">{{ $baocao->created_at->format("d-m-Y H:i:s") }}</pre>
                                        </div>
                                    </div>
                                </div>

                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach
        @else
            <span class="text-danger">Chưa có tiêu chí nào</span>
        @endif
    </div>
</div>

@if (!!$buddy->buddy_tieuchi_duyet && !$baocaoStatus && !$baoCaoTieuChiStatus)
    <div class="col-12">
        <div class="form-group mb-1 mt-1 text-orange">
            <b>Thông tin duyệt tiêu chí:</b>
        </div>

        <div class="row px-3">
            
            <div class="col-md-12 col-12">
                <div class="form-group">
                    <label class="col-form-label">Người duyệt:</label>
                    <div>
                        <pre class="form-control px-2 h-auto thotam-pre">{{ $buddy->buddy_tieuchi_duyet->hr->hoten }}</pre>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 col-12">
                <div class="form-group">
                    <label class="col-form-label">Thời gian duyệt:</label>
                    <div>
                        <pre class="form-control px-2 h-auto thotam-pre">{{ $buddy->buddy_tieuchi_duyet->created_at->format("d-m-Y H:i:s") }}</pre>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-12">
                <div class="form-group">
                    <label class="col-form-label">Kết quả duyệt:</label>
                    <div>
                        <span class="form-control px-2 h-auto">
                            @switch($buddy->buddy_tieuchi_duyet->ketqua)
                                @case(19)
                                    Đã duyệt
                                    @break
                                @case(15)
                                    Không duyệt
                                    @break
                                @default
                                    Không có thông tin
                            @endswitch
                        </span>
                    </div>
                </div>
            </div>

            @if (!!$buddy->buddy_tieuchi_duyet->ghichu )
                <div class="col-md-12 col-12">
                    <div class="form-group">
                        <label class="col-form-label">Ghi chú:</label>
                        <div>
                            <pre class="form-control px-2 h-auto thotam-pre">{{ $buddy->buddy_tieuchi_duyet->ghichu }}</pre>
                        </div>
                    </div>
                </div>
            @endif

        </div>

    </div>
@endif