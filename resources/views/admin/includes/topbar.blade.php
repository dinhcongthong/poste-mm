 <div class="bg-secondary p-2 text-white font-weight-bold text-uppercase">
    {{ $breadcrumb }}
</div>
<div class="d-flex align-items-center dropdown show">
    <a class="text-white p-2 align-self-center dropdown-toggle" href="#" role="button" id="dropdownProfileMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        {{ getUserName(Auth::user()) }}
    </a>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownProfileMenu">
        <a class="dropdown-item" href="#">Profile</a>
        <a class="dropdown-item" href="#">Change Password</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item btn-logout" href="#">Logout</a>
    </div>
</div>
