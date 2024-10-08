@props(['paginator', 'scrollTo' => 'body'])

@if (!empty($paginator) && $paginator->hasPages())
@php
$pagination_uiid = Str::random(6);
$current = $paginator->currentPage();
$last = $paginator->lastPage();
$delta = 3;
$startPage = max($current - $delta, 1);
$endPage = min($current + $delta, $last);

// Generate URLs for previous and next pages
$previousUrl = $paginator->previousPageUrl();
$nextUrl = $paginator->nextPageUrl();

// Alpine.js scrollTo functionality snippet
$scrollIntoViewJsSnippet = ($scrollTo !== false)
? "(\$el.closest('$scrollTo') || document.querySelector('$scrollTo')).scrollIntoView()"
: '';
@endphp

<div class="pagination-sec mt-4 text-center">
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">

            {{-- Previous Page Link --}}
            <li class="page-item {{ $paginator->onFirstPage() ? 'disabled' : '' }}" wire:key="paginator-page-{{ $pagination_uiid }}-previous">
                <a class="page-link" href="{{ $paginator->onFirstPage() ? 'javascript:void(0)' : str_replace(url()->current(), Livewire::originalUrl(), $previousUrl) }}" aria-label="@lang('pagination.previous')" @click.prevent="$wire.previousPage('page'); {{ $scrollIntoViewJsSnippet }}" wire:loading.attr="disabled">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>

            {{-- Pagination Links --}}
            @for ($page = $startPage; $page <= $endPage; $page++) <li class="page-item {{ $page == $current ? 'active' : '' }}" wire:key="paginator-page-{{ $pagination_uiid }}-{{ $page }}">
                <a class="page-link {{ $page == $current ? 'active' : '' }}" href="{{ str_replace(url()->current(), Livewire::originalUrl(), $paginator->url($page)) }}" @click.prevent="$wire.gotoPage({{ $page }}, '{{ $paginator->getPageName() }}'); {{ $scrollIntoViewJsSnippet }}" wire:loading.attr="disabled">{{ $page }}</a>
                </li>
                @endfor

                {{-- Next Page Link --}}
                <li class="page-item {{ !$paginator->hasMorePages() ? 'disabled' : '' }}" wire:key="paginator-page-{{ $pagination_uiid }}-next">
                    <a class="page-link" href="{{ !$paginator->hasMorePages() ? 'javascript:void(0)' : str_replace(url()->current(), Livewire::originalUrl(), $nextUrl) }}" wire:click="nextPage('page')" aria-label="@lang('pagination.next')" @click.prevent="$wire.nextPage('page'); {{ $scrollIntoViewJsSnippet }}" wire:loading.attr="disabled">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
        </ul>
    </nav>
</div>
@endif
