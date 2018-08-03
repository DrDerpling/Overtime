<div class="card">
    <form action="{{ route('overtime.update') }}" method="post">
        {{ csrf_field()  }}
        {{ method_field('PUT') }}
        <div class="card-content">
            <span class="card-title">Overtime overview</span>
            @forelse ($overtimes as $overtime)
                <div class="row row-striped row-narrow">
                        <div class="col l2 m4 s12">
                            {{ $overtime->created_at->format('H:i d-m-Y') }}
                        </div>
                        <div class="col l2 m2 s12">
                            {{ $overtime->hours }} Hours
                        </div>
                        <div class="col l7 m5 s12">
                            {{ $overtime->description }}
                        </div>
                </div>
            @empty
                <p>No overtime was found</p>
            @endforelse
        </div>
    </form>
</div>