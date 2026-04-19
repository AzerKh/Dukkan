<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            [
                'user_id' => 2,
                'category_id' => 1,
                'title' => 'Smartphone Samsung Galaxy S24',
                'description' => 'Smartphone dernière génération avec écran AMOLED 6.5 pouces, 256GB stockage, 12GB RAM.',
                'price' => 599.99,
                'stock' => 10,
                'is_active' => true,
                'image_url' => 'https://images.unsplash.com/photo-1610945265064-0e34e5519bbf?w=500',
            ],
            [
                'user_id' => 2,
                'category_id' => 1,
                'title' => 'Laptop Dell Inspiron 15',
                'description' => 'Ordinateur portable Intel Core i5, 8GB RAM, 256GB SSD, écran Full HD.',
                'price' => 799.99,
                'stock' => 5,
                'is_active' => true,
                'image_url' => 'https://images.unsplash.com/photo-1593642632559-0c6d3fc62b89?w=500',
            ],
            [
                'user_id' => 3,
                'category_id' => 2,
                'title' => 'T-Shirt Premium Coton Bio',
                'description' => 'T-shirt en coton 100% bio, disponible en plusieurs couleurs. Confortable et durable.',
                'price' => 29.99,
                'stock' => 50,
                'is_active' => true,
                'image_url' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=500',
            ],
            [
                'user_id' => 3,
                'category_id' => 4,
                'title' => 'Laravel Up & Running',
                'description' => 'Le guide complet pour apprendre Laravel de zéro à expert. Édition 2024.',
                'price' => 39.99,
                'stock' => 20,
                'is_active' => true,
                'image_url' => 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=500',
            ],
            [
                'user_id' => 2,
                'category_id' => 6,
                'title' => 'Vélo de Route Carbon',
                'description' => 'Vélo léger en carbone, idéal pour la route et le sport. 21 vitesses.',
                'price' => 349.99,
                'stock' => 8,
                'is_active' => true,
                'image_url' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=500',
            ],
            [
                'user_id' => 3,
                'category_id' => 1,
                'title' => 'Apple Watch Series 9',
                'description' => 'Montre connectée avec suivi santé avancé, GPS intégré et autonomie 18h.',
                'price' => 449.99,
                'stock' => 15,
                'is_active' => true,
                'image_url' => 'https://images.unsplash.com/photo-1434493789847-2f02dc6ca35d?w=500',
            ],
            [
                'user_id' => 2,
                'category_id' => 5,
                'title' => 'Canapé Moderne 3 Places',
                'description' => 'Canapé confortable en tissu premium, design scandinave moderne.',
                'price' => 899.99,
                'stock' => 3,
                'is_active' => true,
                'image_url' => 'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?w=500',
            ],
            [
                'user_id' => 3,
                'category_id' => 7,
                'title' => 'Kit Skincare Premium',
                'description' => 'Kit complet de soins visage : nettoyant, sérum, hydratant et crème solaire.',
                'price' => 89.99,
                'stock' => 25,
                'is_active' => true,
                'image_url' => 'https://images.unsplash.com/photo-1556228578-8c89e6adf883?w=500',
            ],
        ];

        foreach ($products as $item) {
            $imageUrl = $item['image_url'];
            unset($item['image_url']);
            $item['image'] = $imageUrl;
            Product::create($item);
        }
    }
}