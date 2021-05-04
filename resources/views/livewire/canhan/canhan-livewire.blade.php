<div>
    <!-- Filters and Add Buttons -->
    @include('thotam-buddy::livewire.canhan.sub.filters')

    <!-- Incluce các modal -->
    @include('thotam-buddy::livewire.modal.add_edit_buddy')
    @include('thotam-buddy::livewire.modal.delete_buddy')

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
