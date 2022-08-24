@extends('layouts.app')

@section('content')
	<div class="row">
		<div class="col-xl-6 col-md-6">
			<div class="card mb-4 border-bottom-card border-primary">
				<div class="card-body">
					<div class="d-flex">
						<div class="flex-grow-1">
							<h5>{{ _lang('Active Users') }}</h5>
							<h6 class="pt-1 mb-0"><b>{{ $active_customer }}</b></h6>
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
			{{ _lang('Recent Transactions') }}
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered">
					<thead>
					    <tr>
							<th>{{ _lang('Date') }}</th>
							<th>{{ _lang('User') }}</th>
							<th>{{ _lang('Currency') }}</th>
							<th>{{ _lang('Amount') }}</th>
							<th>{{ _lang('Charge') }}</th>
							<th>{{ _lang('Grand Total') }}</th>
							<th>{{ _lang('DR/CR') }}</th>
							<th>{{ _lang('Type') }}</th>
							<th>{{ _lang('Method') }}</th>
							<th>{{ _lang('Status') }}</th>
					    </tr>
					</thead>
					<tbody>
						@foreach($recent_transactions as $transaction)
							@php
							$symbol = $transaction->dr_cr == 'dr' ? '-' : '+';
                			$class  = $transaction->dr_cr == 'dr' ? 'text-danger' : 'text-success';
							@endphp

{{-- <tr>
    <td>{{ $transaction->created_at }}</td>
    <td>
        {{ $transaction->user->name }}</br>
        {{ $transaction->user->email }}</br>
        {{ $transaction->user->account_number }}</br>
    </td>
    <td>{{ $transaction->currency->name }}</td>
    @if($transaction->dr_cr == 'dr')
    <td>{{ decimalPlace(($transaction->amount - $transaction->fee), currency($transaction->currency->name)) }}</td>
    @else
    <td>{{ decimalPlace(($transaction->amount + $transaction->fee), currency($transaction->currency->name)) }}</td>
    @endif
    <td>{{ $transaction->dr_cr == 'dr' ? '+ '.decimalPlace($transaction->fee, currency($transaction->currency->name)) : '- '.decimalPlace($transaction->fee, currency($transaction->currency->name)) }}</td>
    <td><span class="{{ $class }}">{{ $symbol.' '.decimalPlace($transaction->amount, currency($transaction->currency->name)) }}</span></td>
    <td>{{ strtoupper($transaction->dr_cr) }}</td>
    <td>{{ str_replace('_',' ',$transaction->type) }}</td>
    <td>{{ $transaction->method }}</td>
    <td>{!! xss_clean(transaction_status($transaction->status)) !!}</td>
</tr> --}}

						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
@endsection
