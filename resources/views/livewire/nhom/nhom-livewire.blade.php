<div>
    <!-- Filters and Add Buttons -->
    @include('thotam-buddy::livewire.nhom.sub.filters')

    <!-- Incluce các modal -->
    @include('thotam-buddy::livewire.modal.add_edit_buddy')
    @include('thotam-buddy::livewire.modal.delete_buddy')
    @include('thotam-buddy::livewire.modal.duyet_buddy')
    @include('thotam-buddy::livewire.modal.tieuchi_buddy')
    @include('thotam-buddy::livewire.modal.view_buddy')
    @include('thotam-buddy::livewire.modal.danhgia_buddy')

    <!-- Scripts -->
    @push('livewires')
        <script>
            document.addEventListener("DOMContentLoaded", () => {
                window.thotam_livewire = @this;
                Livewire.emit("dynamic_update_method");
            });
        </script>
    @endpush
</div>
