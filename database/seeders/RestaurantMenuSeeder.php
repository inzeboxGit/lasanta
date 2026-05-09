<?php

namespace Database\Seeders;

use App\Models\LocalAmenity;
use Illuminate\Database\Seeder;

class RestaurantMenuSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['title' => 'Starters', 'small_title' => 'Mozzarella Dippers', 'description' => 'Fried mozzarella sticks, marinara sauce', 'sort_order' => 27],
            ['title' => 'Starters', 'small_title' => 'Onion Rings', 'description' => 'Fried onion rings, smoked aioli', 'sort_order' => 32],
            ['title' => 'Starters', 'small_title' => 'Fried Jalapeno', 'description' => 'Fried jalapeno pickles, cheddar sauce', 'sort_order' => 52],
            ['title' => 'Starters', 'small_title' => 'Buffalo Wings', 'description' => 'Spicy chicken wings, blue cheese sauce, carrot, celery', 'sort_order' => 37],
            ['title' => 'Starters', 'small_title' => 'Chilli Con Carne', 'description' => 'Spicy ground beef, bacon, kidney beans', 'sort_order' => 32],
            ['title' => 'Starters', 'small_title' => 'Potato Skins', 'description' => 'Crispy potato skins; bacon & cheddar or vegetables', 'sort_order' => 42],
            ['title' => 'Mains', 'small_title' => 'Rusty’s Burger', 'description' => 'Smoked pulled beef ribs, bbq sauce, cheddar, crispy onion', 'sort_order' => 27],
            ['title' => 'Mains', 'small_title' => 'Cajun Fish Steak', 'description' => 'Cajun spicied seabass, deep fried baby potatoes, side salad', 'sort_order' => 32],
            ['title' => 'Mains', 'small_title' => 'Southern Fried Chicken', 'description' => 'Cajun coated chicken breast, fries and honey mustard', 'sort_order' => 52],
            ['title' => 'Mains', 'small_title' => 'Crab Cake', 'description' => 'Breaded crab cakes, tartar sauce, apple and fennel salad', 'sort_order' => 37],
            ['title' => 'Mains', 'small_title' => 'Baby Back Ribs', 'description' => 'Bbq glazed baby pork ribs, coleslaw, fries', 'sort_order' => 32],
            ['title' => 'Mains', 'small_title' => 'Smokehouse Combo', 'description' => 'Smoked beef brisket, rib and sausage, coleslaw, cornbread', 'sort_order' => 42],
            ['title' => 'Salads', 'small_title' => 'Ceaser Salad', 'description' => 'Romaine lettuce, croutons, parmigiano, Ceaser dressing.', 'sort_order' => 47],
            ['title' => 'Salads', 'small_title' => 'Waldorf Salad', 'description' => 'Lettuce, celery, apple, grape, walnut, waldorf sauce', 'sort_order' => 52],
            ['title' => 'Salads', 'small_title' => 'Quinoa & Avocado Salad', 'description' => 'Quinoa, avocado, mixed greens. Nuts, dried and fresh fruits', 'sort_order' => 52],
            ['title' => 'Salads', 'small_title' => 'Grilled Salmon Salad', 'description' => 'Grilled salmon, mixed greens, capers, orange slices', 'sort_order' => 37],
            ['title' => 'Salads', 'small_title' => 'Chicken Cobb Salad', 'description' => 'Iceberg lettuce, cherry tomatoes, blue cheese, avocado, bacon', 'sort_order' => 32],
            ['title' => 'Salads', 'small_title' => 'Salad Chicken', 'description' => 'Ceaser dressing. Optional grilled chicken breast', 'sort_order' => 42],
            ['title' => 'Wine', 'small_title' => "Château d'Yquem 2011", 'description' => 'Dessert Wine, Bordeaux, Graves, Sauternes', 'sort_order' => 400],
            ['title' => 'Wine', 'small_title' => 'Alvear Cream NV', 'description' => 'Dessert, Fortified Wine, Andalucia', 'sort_order' => 30],
            ['title' => 'Wine', 'small_title' => "Chateau D'yquem 1990", 'description' => 'Dessert Wine, Bordeaux, Graves, Sauternes', 'sort_order' => 900],
            ['title' => 'Wine', 'small_title' => 'La Grande Année 2007', 'description' => 'Rosé, Champagne', 'sort_order' => 400],
            ['title' => 'Wine', 'small_title' => 'Sine Qua Non 2012', 'description' => 'Syrah, Shiraz & Blends, California', 'sort_order' => 520],
            ['title' => 'Wine', 'small_title' => 'W.S. Keyes Winery 2006', 'description' => 'Merlot, California, Napa, Howell Mountain', 'sort_order' => 240],
            ['title' => 'Breakfast', 'small_title' => 'Egg Benedict', 'description' => 'English muffin, beef, hollandaise sauce, poached egg.', 'sort_order' => 60],
            ['title' => 'Breakfast', 'small_title' => 'Texas Benedict', 'description' => 'English muffin, short ribs, bbq sauce, poached egg.', 'sort_order' => 30],
            ['title' => 'Breakfast', 'small_title' => 'Rusty’s Omlette', 'description' => 'Mozzarella, cheddar, caramelized onion, black beans.', 'sort_order' => 22],
            ['title' => 'Breakfast', 'small_title' => 'Salmon Bagel', 'description' => 'Smoked salmon, cream cheese, dill, rocket, red onion.', 'sort_order' => 30],
            ['title' => 'Breakfast', 'small_title' => 'Breakfast Bagel', 'description' => 'Chocolate, marshmallow, biscuit bar', 'sort_order' => 33],
            ['title' => 'Breakfast', 'small_title' => 'Rusty’s Pancake', 'description' => 'Strawberry, white chocolate, dark chocolate, crispearls', 'sort_order' => 40],
            ['title' => 'Dessert', 'small_title' => 'Bourbon Pecan Pie', 'description' => 'Bourbon pecan stuffed pie, vanilla ice-cream', 'sort_order' => 67],
            ['title' => 'Dessert', 'small_title' => 'New York Cheesecake', 'description' => 'Cheesecake, strawberry & lime salad', 'sort_order' => 50],
            ['title' => 'Dessert', 'small_title' => 'Rusty’s ice-cream', 'description' => 'Vanilla, bourbon, cookie, chocolate ice-cream', 'sort_order' => 32],
            ['title' => 'Dessert', 'small_title' => 'S’mores', 'description' => 'Chocolate chip cookies, marshmallow, chocolate', 'sort_order' => 40],
            ['title' => 'Dessert', 'small_title' => 'Rocky Road', 'description' => 'Chocolate, marshmallow, biscuit bar', 'sort_order' => 42],
            ['title' => 'Dessert', 'small_title' => 'Apple & Pear Crumble', 'description' => 'Caramelized pear and apple, oat crumble, vanilla ice-cream', 'sort_order' => 42],
        ];

        foreach ($items as $item) {
            LocalAmenity::updateOrCreate(
                [
                    'display_context' => LocalAmenity::CONTEXT_RESTAURANT,
                    'title' => $item['title'],
                    'small_title' => $item['small_title'],
                ],
                [
                    'description' => $item['description'],
                    'sort_order' => $item['sort_order'],
                    'image_path' => null,
                    'link_url' => null,
                    'is_published' => true,
                ]
            );
        }
    }
}