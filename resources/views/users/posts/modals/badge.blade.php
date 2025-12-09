@if(session('new_badge'))
    <!-- モーダル -->
    <div class="modal fade" id="badgeModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center p-4">
          <h5 class="modal-title mb-2">New Badge Earned!</h5>
          <img src="{{ asset(session('new_badge')['image_path']) }}" 
               alt="{{ session('new_badge')['name'] }}" 
               style="width:80px; height:80px; object-fit:cover;">
          <h6 class="mt-2">{{ session('new_badge')['name'] }}</h6>
          <p class="small">{{ session('new_badge')['description'] }}</p>
          <button type="button" class="btn btn-primary mt-2" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
@endif


@if(session('new_badge'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var badgeModal = new bootstrap.Modal(document.getElementById('badgeModal'));
        badgeModal.show();
    });
</script>
@endif
