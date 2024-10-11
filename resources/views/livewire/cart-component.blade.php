<div class="container mx-auto py-12 text-white">
    <h1 class="text-3xl font-bold mb-8 text-center">Détails du Panier</h1>

    @if(!empty($cartItems))
        <div class="grid grid-cols-1 gap-6">
            <!-- Liste des produits dans le panier -->
            @foreach($cartItems as $item)
                <div class="flex items-center justify-between bg-white shadow-md rounded-lg p-4 dark:bg-gray-800">
                    <div class="flex items-center">
                        <!-- Image du produit -->
                        <img src="{{ $item['image_url'] }}" alt="{{ $item['name'] }}" class="h-20 w-20 rounded-md object-cover">
                        <div class="ml-4">
                            <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200">{{ $item['name'] }}</h2>
                            <span class="text-gray-600 dark:text-gray-400">{{ number_format($item['price'], 2) }} €</span>
                        </div>
                    </div>

                    <!-- Total par produit -->
                    <div class="text-lg font-semibold text-gray-800 dark:text-gray-200">
                        {{ number_format($item['total'], 2) }} €
                    </div>

                    <!-- Boutons pour modifier la quantité -->
                    <div class="flex items-center gap-1 flex-nowrap">
                        {{-- TODO: RENDRE LES BOUTONS ET LA QUANTITÉ RÉACTIFS --}}
                        <button type="button" class="flex items-center justify-center w-8 h-8 rounded-full bg-slate-300"
                            wire:click="decrement({{ $item['product_id'] }})">-</button>
                        <div class="w-8 text-center">{{ $item['quantity'] }}</div>
                        <button type="button" class="flex items-center justify-center w-8 h-8 rounded-full bg-slate-300"
                            wire:click="increment({{ $item['product_id'] }})">+</button>
                    </div>

                    <!-- Supprimer le produit du panier -->
                    <button wire:click="removeFromCart({{ $item['id'] }})" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                        Supprimer
                    </button>
                </div>
            @endforeach
        </div>

        <!-- Résumé du panier -->
        <div class="mt-8 bg-gray-100 dark:bg-gray-700 p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">Résumé du Panier</h2>
            <div class="flex justify-between items-center mt-4">
                <span class="text-lg font-semibold text-gray-800 dark:text-gray-200">Total :</span>
                <span class="text-lg font-bold text-gray-800 dark:text-gray-200">{{ number_format($total, 2) }} €</span>
            </div>

            <div class="mt-6">
                <button wire:click="checkout" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Passer à la commande
                </button>
            </div>
        </div>
    @else
        <p class="text-center text-gray-800 dark:text-gray-200">Votre panier est vide.</p>
    @endif
</div>
