<div class="card">
    <div class="card-content">
        <span class="card-title">Stats</span>
        <div class="row row-striped row-narrow">
            <div class="col l12 s12 m12">
                Payout hours this month: {{ $payoutHours }}
            </div>
        </div>
        <div class="row row-striped row-narrow">
            <div class="col l12 s12 m12">
                Total over time:
                {{ $overtimeHours }} Hours
                {{ $overtimeMinutes ? $overtimeMinutes . ' Minutes' : '' }}
            </div>
        </div>
        <div class="row row-striped row-narrow">
            <div class="col l12 s12 m12">
                Total vacation days left: {{ auth()->user()->vacation_days }}
            </div>
        </div>
    </div>
    <div class="card-action">
        <div class="row row-stacked">
            <div class="col l6 m6 s12">
                <a href="{{ route('off_time.create') }}">Register off time</a>
            </div>
            <div class="col l6 m6 s12 right-align">
                {{--<a {{ route('payout.create') }}>Payout overtime</a>--}}
            </div>
        </div>
    </div>
</div>
