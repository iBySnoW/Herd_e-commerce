<div class="container mx-auto py-12 text-white">
    <h1 class="text-3xl font-bold text-center mb-8">Nos Produits</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach ($products as $product)
            <livewire:product-card :product="$product" :key="$product->id" />
        @endforeach
    </div>
    {{ $products->links() }}
</div>
