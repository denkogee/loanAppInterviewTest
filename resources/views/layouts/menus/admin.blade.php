<div class="sb-sidenav-menu-heading">{{ _lang('NAVIGATIONS') }}</div>

<a class="nav-link" href="{{ route('dashboard.index') }}">
	<div class="sb-nav-link-icon"><i class="icofont-dashboard-web"></i></div>
	{{ _lang('Dashboard') }}
</a>

<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#users" aria-expanded="false" aria-controls="collapseLayouts">
	<div class="sb-nav-link-icon"><i class="icofont-users-alt-3"></i></div>
	{{ _lang('Users') }}
	<div class="sb-sidenav-collapse-arrow"><i class="icofont-rounded-down"></i></div>
</a>
<div class="collapse" id="users" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
	<nav class="sb-sidenav-menu-nested nav">
            <a class="nav-link" href="{{ route('admin.users.create') }}">{{ _lang('Add New') }}</a>
		<a class="nav-link" href="{{ route('admin.users.index') }}">{{ _lang('All Users') }}</a>
	</nav>
</div>

<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#loans" aria-expanded="false" aria-controls="collapseLayouts">
	<div class="sb-nav-link-icon"><i class="icofont-dollar-minus"></i></div>
	{{ _lang('Loan Management') }}
	{{-- {!! xss_clean(request_count('pending_loans',true)) !!} --}}
	<div class="sb-sidenav-collapse-arrow"><i class="icofont-rounded-down"></i></div>
</a>
<div class="collapse" id="loans" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
	<nav class="sb-sidenav-menu-nested nav">
		<a class="nav-link" href="{{ route('admin.loans.index') }}">{{ _lang('All Loans') }}</a>
		{{-- <a class="nav-link" href="{{ route('admin.loans.admin_calculator') }}">{{ _lang('Loan Calculator') }}</a>
		<a class="nav-link" href="{{ route('admin.loans.create') }}">{{ _lang('Add New Loan') }}</a>
		<a class="nav-link" href="{{ route('admin.loan_products.index') }}">{{ _lang('Loan Products') }}</a>
		<a class="nav-link" href="{{ route('admin.loan_payments.index') }}">{{ _lang('Loan Repayments') }}</a> --}}
	</nav>
</div>

<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#reports" aria-expanded="false" aria-controls="collapseLayouts">
	<div class="sb-nav-link-icon"><i class="icofont-chart-line-alt"></i></div>
	{{ _lang('Report') }}
	<div class="sb-sidenav-collapse-arrow"><i class="icofont-rounded-down"></i></div>
</a>
<div class="collapse" id="reports" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
	<nav class="sb-sidenav-menu-nested nav">
		{{-- <a class="nav-link" href="{{ route('reports.loan_report') }}">{{ _lang('Loan Reports') }}</a> --}}
	</nav>
</div>
