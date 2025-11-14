@once
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/procedures.css') }}">
    @endpush
@endonce

<div class="procedure-layout">
    <div class="procedure-card">
        <div class="procedure-card__body">
            <table class="procedure-table">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Contenido</th>
                        <th class="text-right">Orden</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>—</td>
                        <td>Pronto tendrás contenido aquí.</td>
                        <td class="text-right">1</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
