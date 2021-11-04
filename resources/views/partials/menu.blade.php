<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion" style="background-color: #E5E5E5;">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <a class="nav-link mb-3 mt-3 menu-halfround" href="{{ url('/dashboard')}}">
                    <div class="sb-nav-link-icon"><i class="fas fa-home"></i></div>
                    Dashboard
                </a>
                <a class="nav-link menu-halfround" href="{{ url('/company')}}">
                    <div class="sb-nav-link-icon"><i class="fas fa-building"></i></div>
                    Company
                </a>
                <a class="nav-link menu-halfround" href="{{ url('/merchant')}}">
                    <div class="sb-nav-link-icon"><i class="fas fa-store"></i></div>
                    Merchant
                </a>
                <a class="nav-link menu-halfround active" href="{{ url('/event')}}">
                    <div class="sb-nav-link-icon"><i class="fa fa-calculator" aria-hidden="true"></i></div>
                    Event / Formula
                </a>
                <a class="nav-link menu-halfround" href="{{ url('/billing')}}">
                    <div class="sb-nav-link-icon"><i class="fas fa-receipt"></i></div>
                    Billing
                </a>
                <a class="nav-link menu-halfround" href="{{ url('/help')}}">
                    <div class="sb-nav-link-icon"><i class="far fa-question-circle"></i></div>
                    Help
                </a>
            </div>
        </div>
    </nav>
</div>

<script>
    let lists = document.querySelectorAll('a');
    lists.forEach(list => {
        if (list.href == location.href) {
            list.classList.add('active');
        } else {
            list.classList.remove('active');
        }
    });
</script>
