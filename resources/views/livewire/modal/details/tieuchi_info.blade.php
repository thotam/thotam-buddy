<div class="col-12">
    <div class="form-group mb-1 mt-1 text-orange">
        <b>Danh sách tiêu chí:</b>
    </div>

    <div class="row px-3">
        @if (count($buddy_tieuchies) !== 0)
            @foreach ($buddy_tieuchies as $buddy_tieuchi)
                <div class="col-md-12 col-12 mt-1">
                    <div class="form-group">
                        <label class="col-form-label text-orange">
                            Tiêu chí {{ $loop->index + 1}}:

                            @if ($lenTieuChiStatus && ($buddy->trangthai_id == 9 || $buddy->trangthai_id == 11))
                                <i wire:key="edit_{{ $loop->index }}" thotam-blockui wire:click.prevent="edit_tieuchi_buddy({{ $buddy_tieuchi->id }})" class='action-icon text-twitter fas fa-edit ml-3'></i>
                                <i wire:key="trash_{{ $loop->index }}" thotam-blockui wire:click.prevent="delete_tieuchi_buddy({{ $buddy_tieuchi->id }})" class='action-icon text-danger fas fa-trash-alt ml-3'></i>
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

            @endforeach
        @else
            <span class="text-danger">Chưa có tiêu chí nào</span>
        @endif
    </div>
</div>
