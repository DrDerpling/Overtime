<div class="card">
    <div class="card-content">
        <span class="card-title">Upcoming off time</span>
        @forelse($offTimes as $offTime)
            <div class="row row-striped">
                <div class="col s10 l10 m10">
                    <div class="col s12 l6 m12">
                        Start Date:
                        {{ $offTime->start_date ? $offTime->start_date->format('d-m-Y') : 'no date specified' }}
                    </div>
                    <div class="col s12 l6 m12">
                        End Date:
                        {{ $offTime->end_date ? $offTime->end_date->format('d-m-Y') : 'no date specified'  }}
                    </div>
                </div>
                <div class="col s2 l2 m2">
                    <a href="{{ route('off_time.edit', $offTime) }}">Edit</a>
                </div>
            </div>

        @empty
            <p>No off time was found</p>
        @endforelse
    </div>
</div>
