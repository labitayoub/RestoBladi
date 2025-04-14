<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Menus</th>
            <th>Tables</th>
            <th>Serveur</th>
            <th>Total HT</th>
            <th>TVA</th>
            <th>Total TTC</th>
            <th>Type de paiement</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($sales as $sale)
            <tr>
                <td>
                    {{ $sale->id }}
                </td>
                <td>
                    @foreach($sale->menus as $menu)
                        {{ $menu->title }} - {{ $menu->price }} DH
                        @if(!$loop->last), @endif
                    @endforeach
                </td>
                <td>
                    @foreach($sale->tables as $table)
                        {{ $table->name }}
                        @if(!$loop->last), @endif
                    @endforeach
                </td>
                <td>
                    @if($sale->waiter && $sale->waiter->user)
                        {{ $sale->waiter->user->name }}
                    @else
                        N/A
                    @endif
                </td>
                <td>
                    {{ $sale->total_ht }}
                </td>
                <td>
                    {{ $sale->tva }}
                </td>
                <td>
                    {{ $sale->total_ttc }}
                </td>
                <td>
                    {{ $sale->payment_type === "cash" ? "Espèce" : "Carte bancaire" }}
                </td>
                <td>
                    {{ \Carbon\Carbon::parse($sale->created_at)->format('d/m/Y H:i') }}
                </td>
            </tr>
        @endforeach
        <tr>
            <td colspan="6">
                Rapport de {{ $from }} à {{ $to }}
            </td>
            <td>
                {{ $total }} DH
            </td>
            <td colspan="2">
                Total des ventes
            </td>
        </tr>
    </tbody>
</table>
