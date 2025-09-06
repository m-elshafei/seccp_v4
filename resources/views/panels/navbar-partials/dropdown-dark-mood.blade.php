<ul class="nav navbar-nav">
    <li class="nav-item d-none d-lg-block">
        {{-- <a class="nav-link nav-link-style"
      data-bs-toggle="tooltip" data-bs-placement="bottom" title="تغيير الوضع الى ليلى/نهارى">
        <i class="ficon" data-feather="{{ $configData['theme'] === 'dark' ? 'sun' : 'moon' }}"></i>
      </a> --}}
        {{-- @dd(Auth::user()->id) --}}
        <form action="{{ route('updateTheme', Auth::user()->name) }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="btn btn-sm"><i class="ficon"
                    data-feather="{{ $configData['theme'] === 'dark' ? 'sun' : 'moon' }}"></i>
            </button>
        </form>



    </li>
</ul>
