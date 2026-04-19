<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            'Électronique',
            'Vêtements',
            'Alimentation',
            'Livres',
            'Maison & Jardin',
            'Sport & Loisirs',
            'Beauté & Santé',
            'Jouets & Enfants',
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category,
                'slug' => Str::slug($category),
                'description' => 'Catégorie ' . $category,
            ]);
        }
    }
}