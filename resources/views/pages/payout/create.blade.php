<div class="card">
    <form action="{{ route('payout.store') }}" method="POST">
        {{ csrf_field() }}
        {{ method_field('POST') }}
        <div class="card-content">
            <span class="card-title">Payout overtime</span>
            <div class="row">
                <div class="col l12 m12 s12">
                    <input  name="payout_hours"
                            type="range"
                            id="payout_hours"
                            min="0"
                            max="{{ $totalHours }}"
                            step="0.25" />
                    <label for="payout_hours">Select hours</label>
                    @if($errors->first('payout_hours'))
                        <span class="helper-text" data-error="{{ $errors->first('payout_hours') }}">Helper text</span>
                    @endif
                </div>

            </div>
            <div class="row">
                <div class="col l12 s12 m12">
                    Hours available: {{ $totalHours }}
                </div>
            </div>
        </div>
        <div class="card-action">
            <button class="waves-effect waves-light btn" type="submit">
                Save
            </button>
        </div>
    </form>
</div>
