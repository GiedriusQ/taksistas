@if ($paginator->paginator->last_page >1)
    <div>Page {{$paginator->paginator->current_page}} / {{$paginator->paginator->last_page}}</div>
    <ul class="pagination">
        <li class="{{ ($paginator->paginator->current_page == 1) ? ' disabled' : '' }}">
            <a href="?page={{ $paginator->paginator->current_page-1 }}">Previous</a>
        </li>
        <li class="{{ ($paginator->paginator->current_page == $paginator->paginator->last_page) ? ' disabled' : '' }}">
            <a href="?page={{ $paginator->paginator->current_page+1 }}">Next</a>
        </li>
    </ul>
@endif