<div class='action-div icon-4 px-0 mx-1 d-flex justify-content-around text-center'>

    <div class='col action-icon-w-50 action-icon' thotam-livewire-method='view_buddy' thotam-model-id='{{ $id }}'><i class='text-info fas fa-search'></i></div>

    @if ($trangthai_id == 5)
        <div class='col action-icon-w-50 action-icon' thotam-livewire-method='edit_buddy' thotam-model-id='{{ $id }}'><i class='text-indigo fas fa-edit'></i></div>
    @else
        <div class='col action-icon-w-50'></div>
    @endif

    @if ($trangthai_id == 5 || $trangthai_id == 7 || $trangthai_id == 9)
        <div class='col action-icon-w-50 action-icon' thotam-livewire-method='duyet_buddy' thotam-model-id='{{ $id }}'><i class='text-success fas fa-check-double'></i></div>
    @else
        <div class='col action-icon-w-50'></div>
    @endif

    @if ($trangthai_id == 13)
        <div class='col action-icon-w-50 action-icon' thotam-livewire-method='len_tieuchi_buddy' thotam-model-id='{{ $id }}'><i class='text-orange fas fa-bullseye'></i></div>
    @else
        <div class='col action-icon-w-50'></div>
    @endif

    @if ($trangthai_id == 5)
        <div class='col action-icon-w-50 action-icon' thotam-livewire-method='delete_buddy' thotam-model-id='{{ $id }}'><i class='text-danger fas fa-trash-alt'></i></div>
    @else
        <div class='col action-icon-w-50'></div>
    @endif


</div>