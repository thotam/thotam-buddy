<div class='action-div icon-4 px-0 mx-1 d-flex justify-content-around text-center'>

    <div class='col action-icon-w-50 action-icon' thotam-livewire-method='view_buddy' thotam-model-id='{{ $id }}'><i class='text-info fas fa-search'></i></div>

    @if ($trangthai_id == 5)
        <div class='col action-icon-w-50 action-icon' thotam-livewire-method='edit_buddy' thotam-model-id='{{ $id }}'><i class='text-indigo fas fa-edit'></i></div>
    @else
        <div class='col action-icon-w-50'></div>
    @endif

    @if (($trangthai_id == 9 || $trangthai_id == 11) && $nguoihuongdan_of_buddy_ids->contains($id))
        <div class='col action-icon-w-50 action-icon' thotam-livewire-method='len_tieuchi_buddy' thotam-model-id='{{ $id }}'><i class='text-orange fas fa-bullseye'></i></div>
    @else
        <div class='col action-icon-w-50'></div>
    @endif

    @if (($trangthai_id == 19 || $trangthai_id == 21) && $isMine)
        <div class='col action-icon-w-50 action-icon' thotam-livewire-method='baocao_tieuchi_buddy' thotam-model-id='{{ $id }}'><i class='text-success fas fa-file-upload'></i></div>
    @else
        <div class='col action-icon-w-50'></div>
    @endif

    @if ($trangthai_id == 5)
        <div class='col action-icon-w-50 action-icon' thotam-livewire-method='delete_buddy' thotam-model-id='{{ $id }}'><i class='text-danger fas fa-trash-alt'></i></div>
    @else
        <div class='col action-icon-w-50'></div>
    @endif


</div>