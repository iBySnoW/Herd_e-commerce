<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use App\Models\CartItem;
use App\Models\Order;
use Stripe\Stripe;
use Stripe\PaymentIntent;


class CartComponent extends Component
{
    public $cartItems = [];

    public $total = 0;

    public function mount()
    {
        $this->loadCart();
    }

    // Charger les articles du panier pour l'utilisateur actuel
    #[On('cart:refresh')]
    public function loadCart()
    {
        if (Auth::check()) {
            $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
            $this->cartItems = $cart->items->toArray();
            $this->calculateTotal();
        }
    }

    // Calculer le total du panier
    public function calculateTotal()
    {
        $this->total = array_sum(array_column($this->cartItems, 'total'));
    }

    // Ajouter un produit au panier
    #[On('add-product')]
    public function addToCart($productId)
    {
        if (Auth::check()) {
            $product = Product::find($productId);
            if (!$product) {
                return;
            }
            $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);

            if(!$cart->items()->where('product_id', $productId)->exists()){
                $cart->items()->create(['product_id' => $productId, 'quantity' => 1]);
            }
        }
        $this->loadCart();
        $this->dispatch('showToast', 'Produit ajouté au panier !', 'success');
    }

    // Incrementer la quantité d'un produit dans le panier
    public function increment($id)
    {
        if (Auth::check()) {
            $cart = Cart::firstOrCreate(['user_id'=> Auth::id()]);
            $cartItem = $cart->items()->where('product_id', $id)->first();
            if ($cartItem) {
                $cartItem->increment('quantity');
            }
            $this->loadCart();
        }
    }

    // Decrementer la quantité d'un produit dans le panier
    public function decrement($id)
    {
        if (Auth::check()) {
            $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
            $cartItem = $cart->items()->where('product_id', $id)->first();
            if ($cartItem) {
                $cartItem->decrement('quantity');
                if ($cartItem->quantity <= 0) {
                    $cartItem->delete();
                }
            }
            $this->loadCart();
        }
    }

    public function removeFromCart($cartItemId)
{
    if (Auth::check()) {
        $cartItem = CartItem::find($cartItemId);
        if ($cartItem && $cartItem->cart->user_id == Auth::id()) {
            $cartItem->delete();
        }
    }
    $this->loadCart();
    $this->dispatch('showToast', 'Produit retiré du panier !', 'success');
}

    // Rendu du composant
    public function render()
    {
        return view('livewire.cart-component', [
            'cartItems' => $this->cartItems,
            'total' => $this->total,
        ]);
    }

    // Simuler un paiement Stripe réussi
    public function checkout()
    {


       if (Auth::check()) {


            try {
                Stripe::setApiKey(config('services.stripe.secret'));



                $paymentIntent = PaymentIntent::create([
                    'amount' => $this->total * 100, // Stripe utilise les centimes
                    'currency' => 'eur',
                    'payment_method_types' => ['card'],
                    // Utilisez un numéro de carte de test pour simuler un paiement réussi
                    'payment_method_data' => [
                        'type' => 'card',
                        'card' => [
                            'number' => '4242424242424242',
                            'exp_month' => 12,
                            'exp_year' => 2024,
                            'cvc' => '314',
                        ],
                    ],
                    'confirm' => true,
                ]);

                if ($paymentIntent->status === 'succeeded') {
                    // Créer une commande
                    $order = Order::create([
                        'user_id' => Auth::id(),
                        'total' => $this->total,
                        'status' => 'paid',
                        'stripe_payment_intent_id' => $paymentIntent->id,
                    ]);

                    // Ajouter les articles à la commande
                    foreach ($this->cartItems as $item) {
                        $order->items()->create([
                            'product_id' => $item['product_id'],
                            'quantity' => $item['quantity'],
                            'price' => $item['price'],
                        ]);
                    }


                    // Vider le panier
                    Cart::where('user_id', Auth::id())->delete();

                    // Recharger le panier (qui sera vide maintenant)
                    $this->loadCart();

                    dd($order);

                    // Notifier l'utilisateur
                    $this->dispatch('showToast', 'Paiement effectué avec succès !', 'success');


                    // Rediriger vers une page de confirmation
                    return redirect()->route('order.confirmation', ['order' => $order->id]);
                } else {
                    $this->dispatch('notify', ['message' => 'Erreur lors du paiement. Veuillez réessayer.']);
                }
            } catch (\Exception $e) {
                $this->dispatch('notify', ['message' => 'Erreur : ' . $e->getMessage()]);
            }
        }
    }
}
