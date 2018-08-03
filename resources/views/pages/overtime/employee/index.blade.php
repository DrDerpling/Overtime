<div class="card">
    <form action="{{ route('overtime.update') }}" method="post">
        {{ csrf_field()  }}
        {{ method_field('PUT') }}
        <div class="card-content">
            <span class="card-title">Overtime overview</span>
            @forelse ($overtimes as $overtime)
                <div class="row row-striped valign-wrapper">
                    @if(!$overtime->isUsed())
                        <div class="col m1 l1  s1 ">
                            @component('components.inputs.checkbox')
                                {{ $overtime->id }}
                                @slot('label', '')
                                @slot('name', 'use[]')
                                @slot('checked', $overtime->isUsed())
                            @endcomponent
                        </div>
                    @endif
                    <div for class="col l11 m11 s11">
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
                </div>
                @if($loop->last)
                    <div class="row row-striped valign-wrapper">
                        <div class="col offset-l3 l9 offset-m5 m7 s12">
                            Total: {{ floor($overtimes->sum('hours')) }} Hours <br>
                            Total: {{ floor($overtimes->sum('hours') / 8) }} Days
                        </div>
                    </div>
                @endif
            @empty
                <p>No overtime was found</p>
            @endforelse
        </div>
        <div class="card-action">
            <button class="waves-effect waves-light btn" value="1" name="off_time" type="submit">
                Use selected for days off
            </button>
            <button class="waves-effect waves-light btn" value="1" name="payout" type="submit">Payout
                selected
            </button>
        </div>
    </form>
</div>