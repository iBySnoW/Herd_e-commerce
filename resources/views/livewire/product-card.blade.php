<div class="bg-white shadow-md rounded-lg p-4 dark:bg-gray-800">
    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="h-40 w-full object-cover rounded-md">

    <div class="mt-4">
        <h2 class="text-lg font-bold text-gray-800 dark:text-gray-200">{{ $product->name }}</h2>
        <p class="text-gray-600 dark:text-gray-400 mt-2">{{ $product->description }}</p>
        <div class="mt-4 flex justify-between items-center">
            <span class="text-lg font-semibold text-gray-800 dark:text-gray-200">{{ number_format($product->price, 2) }} €</span>
            <button wire:click="addToCart({{$product->id}})" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                Ajouter au panier
            </button>
        </div>
    </div>
</div>
