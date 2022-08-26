@extends('layouts.app')

@section('content')
	<div class="row">
		<div class="col-xl-6 col-md-6">
			<div class="card mb-4 border-bottom-card border-primary">
				<div class="card-body">
					<div class="d-flex">
						<div class="flex-grow-1">
							<h5>{{ _lang('Active Users') }}</h5>
							{{-- <h6 class="pt-1 mb-0"><b>{{ $active_customer }}</b></h6> --}}
						</div>
						<div>
							<a href="#"><i class="icofont-arrow-right"></i>{{ _lang('View') }}</a>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-xl-6 col-md-6">
			<div class="card mb-4 border-bottom-card border-success">
				<div class="card-body">
					<div class="d-flex">
						<div class="flex-grow-1">
							<h5>{{ _lang('Loan Requests') }}</h5>
							<h6 class="pt-1 mb-0"><b>{{ request_count('pending_loans') }}</b></h6>
						</div>
						<div>
							<a href="{{ route('admin.loans.index') }}"><i class="icofont-arrow-right"></i>{{ _lang('View') }}</a>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>

	<div class="card mb-4">
		<div class="card-header">
			{{ _lang('All Loans ') }}
		</div>
        <div class="card-body">
            <table id="loans_table" class="table table-bordered">
                <thead>
                    <tr>
                        <th>{{ _lang('Loan ID') }}</th>
                        <th>{{ _lang('Loan Product') }}</th>
                        <th>{{ _lang('Borrower') }}</th>
                        <th>{{ _lang('AC Number') }}</th>
                        <th>{{ _lang('Release Date') }}</th>
                        <th>{{ _lang('Applied Amount') }}</th>
                        <th>{{ _lang('Status') }}</th>
                        <th class="text-center">{{ _lang('Action') }}</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
	</div>
@endsection


@section('js-script')
<script src="{{ asset('backend/assets/js/datatables/loans.js') }}"></script>
@endsection
