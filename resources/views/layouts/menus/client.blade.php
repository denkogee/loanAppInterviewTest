<div class="sb-sidenav-menu-heading">{{ _lang('NAVIGATIONS') }}</div>

{{-- <a class="nav-link" href="{{ route('client.dashboard.index') }}">
	<div class="sb-nav-link-icon"><i class="icofont-dashboard-web"></i></div>
	{{ _lang('Dashboard') }}
</a> --}}

{{-- <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#loans" aria-expanded="false" aria-controls="collapseLayouts">
	<div class="sb-nav-link-icon"><i class="icofont-dollar-minus"></i></div>
	{{ _lang('Loans') }}
	<div class="sb-sidenav-collapse-arrow"><i class="icofont-rounded-down"></i></div>
</a>
<div class="collapse" id="loans" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
	<nav class="sb-sidenav-menu-nested nav">
		<a class="nav-link" href="{{ route('client.loans.apply_loan') }}">{{ _lang('Apply New Loan') }}</a>
		<a class="nav-link" href="{{ route('client.loans.my_loans') }}">{{ _lang('My Loans') }}</a>
		<a class="nav-link" href="{{ route('client.loans.calculator') }}">{{ _lang('Loan Calculator') }}</a>
	</nav>
</div> --}}

<a class="nav-link" href="{{ route('client.loans.apply_loan') }}">
	<div class="sb-nav-link-icon"><i class="icofont-dollar-minus"></i></div>
	{{ _lang('Apply New Loan') }}
</a>

<a class="nav-link" href="{{ route('client.loans.my_loans') }}">
	<div class="sb-nav-link-icon"><i class="icofont-dollar-minus"></i></div>
	{{ _lang('My Loans') }}
</a>

{{-- <a class="nav-link" href="{{ route('client.loans.calculator') }}">
	<div class="sb-nav-link-icon"><i class="icofont-dollar-minus"></i></div>
	{{ _lang('Loan Calculator') }}
</a> --}}
