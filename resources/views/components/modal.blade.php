<!-- Modal Structure -->
<div id="{{ $id }}" class="modal">
    <form action="{{ $action }}">
        {{ method_field($method ?: 'GET') }}
        {{ csrf_field() }}
        <div class="modal-content">
            <h4>{{ $title ?: 'No title was given' }}</h4>
            <p>{{ $slot }}</p>
        </div>
        <div class="modal-footer">
            <button type="submit" class="modal-close waves-effect waves-green btn-flat">Agree</button>
        </div>
    </form>
</div>