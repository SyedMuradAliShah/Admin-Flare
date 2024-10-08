@props(['colspan' => 0])

@if($colspan > 0)
<tr>
    <td colspan="{{ $colspan }}">
        @endif

        <div class="empty-table py-3 rounded-4">
            <div class="empty-text text-center p-5 rounded-4 mx-auto">
                <img src="{{ asset('assets/images/data-not-found.png') }}" width="200px" alt="Data Not Found" />
                <h6 class="fw-bold">Nothing Found</h6>
                <p class="mb-0 small">Currently you don't have any data</p>
            </div>
        </div>

        @if($colspan > 0)
    </td>
</tr>
@endif
