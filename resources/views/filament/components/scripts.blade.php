@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll('.receipt-preview').forEach(img => {
        img.addEventListener('click', function () {
            let url = this.getAttribute('data-url');
            if (!url) return;
            Swal.fire({
                imageUrl: url,
                imageAlt: 'Receipt',
                showCloseButton: true,
                showConfirmButton: false,
                width: 'auto',
            });
        });
    });
});
</script>
@endpush
