<div wire:ignore.self class="modal fade" id="view_buddy_modal" tabindex="-1" role="dialog" aria-labelledby="view_buddy_modal" aria-hidden="true" data-toggle="modal" data-backdrop="static" data-keyboard="false">

    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content py-2">
            <div class="modal-header">
                <h4 class="modal-title text-purple"><span class="fas fa-user-friends mr-3"></span>{{ $modal_title }}</h4>
                <button type="button" wire:click.prevent="cancel()" thotam-blockui class="close" data-dismiss="modal" wire:loading.attr="disabled" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            @if ($viewStatus)
                <div class="modal-body">
                    <div class="container-fluid mx-0 px-0">
                        <form>
                            <div class="row">

                                @include('thotam-buddy::livewire.modal.details.basic_info')

                                @include('thotam-buddy::livewire.modal.details.duyet_info')
                                
                                @if (count($buddy_tieuchies) != 0)
                                    @include('thotam-buddy::livewire.modal.details.tieuchi_info')
                                @endif

                                @include('thotam-buddy::livewire.modal.details.danhgia_info')

                            </div>
                        </form>
                    </div>
                </div>
            @endif

            <div class="modal-footer mx-auto">
                <button wire:click.prevent="cancel()" thotam-blockui class="btn btn-danger" wire:loading.attr="disabled" data-dismiss="modal">Đóng</button>
            </div>

        </div>
    </div>

</div>
