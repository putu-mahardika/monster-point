<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion" style="background-color: #E5E5E5;">
        <div class="sb-sidenav-menu">
            <div class="nav">
                @can('dashboard access')
                    <a class="nav-link mt-3 menu-halfround" href="{{ url('/dashboard')}}">
                        <div class="sb-nav-link-icon"><i class="fas fa-home"></i></div>
                        Dashboard
                    </a>
                @endcan
                @can('merchants access')
                    <a class="nav-link menu-halfround" href="{{ url('/merchants')}}">
                        <div class="sb-nav-link-icon"><i class="fas fa-store"></i></div>
                        Merchants
                    </a>
                @endcan
                @can('members access')
                    <a class="nav-link menu-halfround" href="{{ url('/members')}}">
                        <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                        Members
                    </a>
                @endcan
                @can('events access')
                    <a class="nav-link menu-halfround active" href="{{ url('/events')}}">
                        <div class="sb-nav-link-icon"><i class="fa fa-calculator" aria-hidden="true"></i></div>
                        Events
                    </a>
                @endcan
                <a class="nav-link menu-halfround" href="{{ url('/billing')}}">
                    <div class="sb-nav-link-icon"><i class="fas fa-receipt"></i></div>
                    Billings
                </a>
                <a class="nav-link menu-halfround" href="http://127.0.0.1:8000/api/documentation">
                    <div class="sb-nav-link-icon"><i class="far fa-question-circle"></i></div>
                    Helps
                </a>
            </div>
        </div>
    </nav>
</div>

<script>
    const getRootPathDocumentLocation = () => {
        return window.location.pathname.split('/').filter((item) => {
            if (item !== '') {
                return item;
            }
        })[0];
    }

    let lists = document.querySelectorAll('a');
    lists.forEach(list => {
        if (list.href.indexOf(getRootPathDocumentLocation()) >= 0) {
            list.classList.add('active');
        } else {
            list.classList.remove('active');
        }
    });
</script>
