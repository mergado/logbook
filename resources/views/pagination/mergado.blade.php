<?php
// config
$link_limit = 6; // maximum number of links (a little bit inaccurate, but will be ok for now)
?>

@if ($paginator->lastPage() > 1)
    <div class="paginator">

        @if ($paginator->currentPage() == 1)
            <span>« {!! trans('log.previous') !!}</span>
        @else
            <a href="{{ $paginator->url($paginator->currentPage()-1) }}">« {!! trans('log.previous') !!}</a>
        @endif

        @for ($i = 1; $i <= $paginator->lastPage(); $i++)
            <?php
            $half_total_links = floor($link_limit / 2);
            $from = $paginator->currentPage() - $half_total_links;
            $to = $paginator->currentPage() + $half_total_links;
            if ($paginator->currentPage() < $half_total_links) {
                $to += $half_total_links - $paginator->currentPage();
            }
            if ($paginator->lastPage() - $paginator->currentPage() < $half_total_links) {
                $from -= $half_total_links - ($paginator->lastPage() - $paginator->currentPage()) - 1;
            }
            ?>
            @if ($from < $i && $i < $to)

                @if ($paginator->currentPage() == $i)
                        <span class="current">{{ $i }}</span>
                @else
                    <a href="{{ $paginator->url($i) }}">{{ $i }}</a>
                @endif

            @endif

        @endfor

            @if ($paginator->currentPage() == $paginator->lastPage())
                <span>{!! trans('log.next') !!} »</span>
            @else
                <a href="{{ $paginator->url($paginator->currentPage()+1) }}" >{!! trans('log.next') !!} »</a>
            @endif

    </div>
@endif