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
</div>
