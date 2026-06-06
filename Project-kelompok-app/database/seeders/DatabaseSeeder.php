<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@karsastudio.test'],
            [
                'name' => 'Admin Karsa Studio',
                'password' => 'password123',
                'is_admin' => true,
            ]
        );

        \App\Models\Product::updateOrCreate(
            ['slug' => 'mesa-wallpaper-pack'],
            [
                'name' => 'Mesa Wallpaper Pack',
                'description' => 'A curation of 12 ultra-high resolution abstract warm gradients and fluid 8K wallpaper designs. Designed to induce focus and visual harmony on your desktop, laptop, and mobile screens.',
                'price' => 29000.00,
                'image_path' => 'images/mesa_wallpaper.png',
                'download_url' => 'https://example.com/downloads/mesa-wallpaper-pack.zip',
            ]
        );

        \App\Models\Product::updateOrCreate(
            ['slug' => 'zen-monolithic-icons'],
            [
                'name' => 'Zen Monolithic Icons',
                'description' => 'Over 240+ carefully crafted minimalist monochrome app icons for iOS, Android, and macOS. Includes dark, light, and wireframe variants alongside matching home screen widgets.',
                'price' => 49000.00,
                'image_path' => 'images/zen_icons.png',
                'download_url' => 'https://example.com/downloads/zen-monolithic-icons.zip',
            ]
        );

        \App\Models\Product::updateOrCreate(
            ['slug' => 'aura-notion-dashboard'],
            [
                'name' => 'Aura Notion Dashboard',
                'description' => 'A beautifully unified, premium dark-mode productivity workspace for Notion. Organize your projects, tracking systems, quick thoughts, journal logs, and weekly objectives in one integrated dashboard.',
                'price' => 79000.00,
                'image_path' => 'images/aura_notion.png',
                'download_url' => 'https://example.com/downloads/aura-notion-dashboard.zip',
            ]
        );

        \App\Models\Product::updateOrCreate(
            ['slug' => 'focus-journal-pdf'],
            [
                'name' => 'Focus Journal (PDF)',
                'description' => 'A printable 30-day structural daily log and journal designed around focus, mindfulness, and intentional reflection. Features premium typography, clean layouts, and guided prompts.',
                'price' => 19000.00,
                'image_path' => 'images/focus_journal.png',
                'download_url' => 'https://example.com/downloads/focus-journal.pdf',
            ]
        );
    }
}
