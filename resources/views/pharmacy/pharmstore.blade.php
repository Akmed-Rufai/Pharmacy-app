<x-layout>

    <ul class="max-w-screen-sm mx-auto mt-10">
            <input
             type="text"
             id="medicine-search"
             name="medicine-search"
             style="width: 640px; outline: none">
        <div id="search-result">
            @include('pharmacy.partials.medicine-store', ['medicines' => $medicines])
        </div>
    </ul>
</x-layout>

<script>
    document.addEventListener('DOMContentLoaded', function () {
      const input = document.getElementById('medicine-search');
      const resultsContainer = document.getElementById('search-result');
  
      input.addEventListener('input', function () {
        const query = this.value;
  
        fetch(`{{ route('pharmacy.pharmstore') }}?medicine=${encodeURIComponent(query)}`, {
          headers: {
            'X-Requested-With': 'XMLHttpRequest'
          }
        })
        .then(response => response.text())
        .then(html => {
          resultsContainer.innerHTML = html;
        })
        .catch(error => {
          console.error('Search error:', error);
        });
      });
    });
  </script>
  