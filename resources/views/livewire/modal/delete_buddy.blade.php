<div wire:ignore.self class="modal fade" id="delete_buddy_modal" tabindex="-1" role="dialog" aria-labelledby="delete_buddy_modal" aria-hidden="true" data-toggle="modal" data-backdrop="static" data-keyboard="false">

    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content py-2">
            <div class="modal-header">
                <h4 class="modal-title text-danger"><span class="fas fa-user-friends mr-3"></span>{{ $modal_title }}</h4>
                <button type="button" wire:click.prevent="cancel()" thotam-blockui class="close" data-dismiss="modal" wire:loading.attr="disabled" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            @if ($deleteStatus)
                <div class="modal-body">
                    <div class="container-fluid mx-0 px-0">
                        <form>
                            <div class="row">

                                <div class="col-12 mb-3 text-danger font-weight-semibold">
                                    Bạn sẽ xóa Buddy có thông tin như sau, việc xóa là KHÔNG THỂ khôi phục,bạn có chắc chắn?
                                </div>

                                @include('thotam-buddy::livewire.modal.details.basic_info')

                            </div>
                        </form>
                    </div>
                </div>
            @endif

            <div class="modal-footer mx-auto">
                <button wire:click.prevent="cancel()" thotam-blockui class="btn btn-info" wire:loading.attr="disabled" data-dismiss="modal">Đóng</button>
                <button wire:click.prevent="delete_buddy_action()" thotam-blockui class="btn btn-danger" wire:loading.attr="disabled">Xác nhận</button>
            </div>

        </div>
    </div>

</div>
