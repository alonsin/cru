@if ($errors->any())
<div {{ $attributes }}>
    <ul class="mt-3 list-disc list-inside text-sm text-red-600">
        @foreach ($errors->all() as $error)

        {{ $error == 'These credentials do not match our records.' ? 'Estas credenciales no coinciden con nuestros registros.' : $error }}

        @endforeach
    </ul>
</div>
@endif