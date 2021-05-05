@if (!!$buddy->buddy_duyet)

    @php
        $buddy_duyet= $buddy->buddy_duyet;
    @endphp

    <div class="col-md-12 col-12">
        <div class="form-group">
            <label class="col-form-label text-success">Kết quả duyệt:</label>
            <div>
                <span type="text" class="form-control px-2 h-auto">{{ $buddy_duyet->ketqua_duyet->trangthai }}</span>
            </div>
        </div>
    </div>

    @if ($buddy_duyet->ketqua == 9 && !!$buddy->nguoihuongdans)
        <div class="col-md-12 col-12">
            <div class="form-group">
                <label class="col-form-label text-success">Người hướng dẫn:</label>
                <div>
                    <span type="text" class="form-control px-2 h-auto">{{ $buddy->nguoihuongdans->pluck("hoten")->implode(', ') }}</span>
                </div>
            </div>
        </div>
    @endif

    @if (!!$buddy_duyet->ghichu)
        <div class="col-md-12 col-12">
            <div class="form-group">
                <label class="col-form-label text-success">Thông tin khác:</label>
                <div>
                    <pre class="form-control px-2 h-auto thotam-pre">{{ $buddy_duyet->ghichu }}</pre>
                </div>
            </div>
        </div>
    @endif

    <div class="col-md-6 col-12">
        <div class="form-group">
            <label class="col-form-label text-success">Người duyệt Buddy:</label>
            <div>
                <pre class="form-control px-2 h-auto thotam-pre">{{ $buddy_duyet->hr->hoten }}</pre>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 col-12">
        <div class="form-group">
            <label class="col-form-label text-success">Thời gian duyệt Buddy:</label>
            <div>
                <pre class="form-control px-2 h-auto thotam-pre">{{ $buddy_duyet->created_at->format("d-m-Y H:i:s") }}</pre>
            </div>
        </div>
    </div>

@endif