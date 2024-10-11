<x-app-layout>
    <div class="container mx-auto py-12">
        <h1 class="text-3xl font-bold mb-8 text-center">Confirmation de commande</h1>
        <div class="bg-white shadow-md rounded-lg p-6">
            <p class="text-xl mb-4">Merci pour votre commande !</p>
            <p>Numéro de commande : {{ $order->id }}</p>
            <p>Total : {{ number_format($order->total, 2) }} €</p>
            <h2 class="text-2xl font-bold mt-6 mb-4">Articles commandés :</h2>
            <ul>
                @foreach ($order->items as $item)
                    <li>{{ $item->product->name }} - Quantité : {{ $item->quantity }} - Prix : {{ number_format($item->price, 2) }} €</li>
                @endforeach
            </ul>
        </div>
    </div>
</x-app-layout>
