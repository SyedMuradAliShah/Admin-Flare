@props(['item'])

<div class="text-start small p-2 mt-2 border-top">
    Showing {{ $item->firstItem() }} to {{ $item->lastItem() }} of {{ $item->total() }} results
</div>
