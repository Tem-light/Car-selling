<?php
/** @var \Illuminate\Pagination\LengthAwarePaginator $paginator */
?>
@if ($paginator->hasPages())
  <nav class="flex items-center justify-center gap-1 my-8">
                @if ($paginator->onFirstPage())
                  <span class="inline-flex items-center justify-center w-10 h-10 rounded-full border border-gray-200 dark:border-gray-600 bg-gray-100 dark:bg-gray-800 text-gray-400 dark:text-gray-500 cursor-not-allowed">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                      stroke="currentColor" style="width: 18px">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                    </svg>
                    </span>
                @else
                  <a href="{{ $paginator->previousPageUrl() }}" class="inline-flex items-center justify-center w-10 h-10 rounded-full border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                      stroke="currentColor" style="width: 18px">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                    </svg>
                    </a>
                @endif
                @foreach ($elements as $element)
                    @if (is_string($element))
                        <span class="px-2 text-gray-500 dark:text-gray-400">{{ $element }}</span>
                    @endif
                    @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span class="inline-flex items-center justify-center min-w-[2.5rem] h-10 rounded-full bg-primary text-white font-medium">{{ $page }}</span>
                                @else
                                    <a href="{{ $url }}" class="inline-flex items-center justify-center min-w-[2.5rem] h-10 rounded-full border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition">{{ $page }}</a>
                                @endif
                            @endforeach
                    @endif
                @endforeach
              @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="inline-flex items-center justify-center w-10 h-10 rounded-full border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" style="width: 18px">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                    </svg>
                </a>
              @else
                <span class="inline-flex items-center justify-center w-10 h-10 rounded-full border border-gray-200 dark:border-gray-600 bg-gray-100 dark:bg-gray-800 text-gray-400 dark:text-gray-500 cursor-not-allowed">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" style="width: 18px">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                    </svg>
                </span>
              @endif
              
            
            </nav>
@endif