<div class="text-center">
    {!! QrCode::size(200)->generate(url('/user/' . $user->id)) !!}
</div>
