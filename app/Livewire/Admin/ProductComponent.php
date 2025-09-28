<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;
use App\Models\Product;
use App\Models\OrderItem;

class ProductComponent extends Component
{
    use WithFileUploads; // Enable file uploads

    public $showModal = false; // Controls modal visibility
    public $layout = 'layouts.admin'; // Specify the layout view
    public $productId;
    public $name, $category, $price, $stock;
    public $image;
    public $image_url;
    public $status = 'active';
    public $showDeleteModal = false; // controls delete modal
    public $productToDelete;         // holds the product being deleted

    protected $rules = [
        'name' => 'required|string',
        'category' => 'required|string',
        'price' => 'required|numeric',
        'stock' => 'required|integer',
        'image' => 'nullable|image',
    ];

    public function openModal($productId = null)
    {
        $this->resetForm();
        if ($productId) {
            $product = Product::find($productId);
            $this->productId = $product->id;
            $this->name = $product->name;
            $this->category = $product->category;
            $this->price = $product->price;
            $this->stock = $product->stock;
            $this->status = $product->status;
            $this->image_url = $product->image_url;
        }
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function saveProduct()
    {
        $this->validate();

        $imagePath = $this->productId ? Product::find($this->productId)->image_url : null;

        if ($this->image) {
            $filename = $this->image->getClientOriginalName();
            $this->image->storeAs('products', $filename, 'public');
            $imagePath = 'products/' . $filename;
        }

        $finalStock = $this->status === 'discontinued' ? '-' : $this->stock;

        Product::updateOrCreate(
            ['id' => $this->productId],
            [
                'name' => $this->name,
                'category' => $this->category,
                'price' => $this->price,
                'stock' => $finalStock,
                'status' => $this->status,
                'image_url' => $imagePath,
            ]
        );

        $this->closeModal();
        session()->flash('success', 'Product saved successfully!');

    }

    private function resetForm()
    {
        $this->productId = null;
        $this->name = '';
        $this->category = '';
        $this->price = '';
        $this->stock = '';
        $this->status = 'active';
        $this->image_url = null;
    }

    public function confirmDelete($id)
    {
        $this->productToDelete = Product::find($id);
        $this->showDeleteModal = true;
    }

    public function deleteConfirmed()
    {
        if ($this->productToDelete) {
            // check if this product exists in past orders
            $hasOrders = OrderItem::where('product_id', $this->productToDelete->id)->exists();

            if ($hasOrders) {
                // Mark as discontinued instead of deleting
                $this->productToDelete->update([
                    'status' => 'discontinued',
                    'stock' => null,
                ]);
                session()->flash(
                    'error',
                    'Cannot delete this product because it exists in past orders. It has been marked as discontinued.'
                );
            } else {
                // Safe to delete
                $this->productToDelete->delete();
                session()->flash('success', 'Product deleted successfully!');
            }
        }

        $this->showDeleteModal = false;
        $this->productToDelete = null;
    }

    #[Layout('layouts.admin')]
    public function render()
    {
        return view('livewire.admin.product-component', [
            'products' => Product::orderBy('id', 'desc')->paginate(5),
        ]);
    }
}