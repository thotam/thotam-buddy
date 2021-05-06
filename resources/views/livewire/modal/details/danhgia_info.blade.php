@if (!!$buddy->buddy_danhgia)

    @php
        $danhgia = $buddy->buddy_danhgia;
    @endphp

    <div class="col-md-6 col-12">
        <div class="form-group">
            <label class="col-form-label text-success">Kết quả đánh giá:</label>
            <div>
                <span type="text" class="form-control px-2 h-auto">
                    @switch($danhgia->danhgia)
                        @case(25)   
                            Không đạt
                            @break
                        @case(27)
                            Đạt
                            @break
                        @default
                            Không có thông tin
                    @endswitch
                </span>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-12">
        <div class="form-group">
            <label class="col-form-label text-success">Đề xuất thưởng tiền:</label>
            <div>
                <span type="text" class="form-control px-2 h-auto">
                    @switch($danhgia->danhgia)
                        @case(false)   
                            Không
                            @break
                        @case(true)
                            Có
                            @break
                        @default
                        Không có thông tin
                    @endswitch
                </span>
            </div>
        </div>
    </div>

    <div class="col-md-12 col-12">
        <div class="form-group">
            <label class="col-form-label text-success">Nội dung đánh giá:</label>
            <div>
                <pre class="form-control px-2 h-auto thotam-pre">{{ $danhgia->noidung }}</pre>
            </div>
        </div>
    </div>

    @if (!!$danhgia->ghichu)
        <div class="col-md-12 col-12">
            <div class="form-group">
                <label class="col-form-label text-success">Thông tin khác:</label>
                <div>
                    <pre class="form-control px-2 h-auto thotam-pre">{{ $danhgia->ghichu }}</pre>
                </div>
            </div>
        </div>
    @endif

    <div class="col-md-6 col-12">
        <div class="form-group">
            <label class="col-form-label text-success">Người đánh giá Buddy:</label>
            <div>
                <pre class="form-control px-2 h-auto thotam-pre">{{ $danhgia->hr->hoten }}</pre>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 col-12">
        <div class="form-group">
            <label class="col-form-label text-success">Thời gian đánh giá Buddy:</label>
            <div>
                <pre class="form-control px-2 h-auto thotam-pre">{{ $danhgia->created_at->format("d-m-Y H:i:s") }}</pre>
            </div>
        </div>
    </div>

@endif