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

<div class="col-md-12 col-12">
    <div class="form-group">
        <label class="col-form-label">Bộ phận/Nhóm:</label>
        <div>
            <span type="text" class="form-control px-2 h-auto">{{ $buddy->nhom->full_name }}</span>
        </div>
    </div>
</div>

<div class="col-md-12 col-12">
    <div class="form-group">
        <label class="col-form-label">Nhu cầu đào tạo:</label>
        <div>
            <pre class="form-control px-2 h-auto thotam-pre">{{ $buddy->nhucau }}</pre>
        </div>
    </div>
</div>

@if (!!$buddy->ghichu)
    <div class="col-md-12 col-12">
        <div class="form-group">
            <label class="col-form-label">Thông tin khác:</label>
            <div>
                <pre class="form-control px-2 h-auto thotam-pre">{{ $buddy->ghichu }}</pre>
            </div>
        </div>
    </div>
@endif

<div class="col-md-6 col-12">
    <div class="form-group">
        <label class="col-form-label">Người đăng ký:</label>
        <div>
            <pre class="form-control px-2 h-auto thotam-pre">{{ $buddy->hr->hoten }}</pre>
        </div>
    </div>
</div>

<div class="col-md-6 col-12">
    <div class="form-group">
        <label class="col-form-label">Thời gian đăng ký:</label>
        <div>
            <pre class="form-control px-2 h-auto thotam-pre">{{ $buddy->created_at->format("d-m-Y H:i:s") }}</pre>
        </div>
    </div>
</div>