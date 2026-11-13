<?php

namespace Database\Seeders;

use App\Models\Merchant;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    private function ensureDemoQrisSvg(string $slug, string $merchantName): string
    {
        $path = "qris-images/demo-{$slug}.svg";
        if (Storage::disk('public')->exists($path) && ! str_contains((string) Storage::disk('public')->get($path), '&bull;')) {
            return $path;
        }

        // Deterministic 11x11 QR matrix from slug hash (sharp, realistic, zero external API needed)
        $hash = md5($slug);
        $rects = '';
        $cell = 12;
        $offset = 44;

        for ($r = 0; $r < 11; $r++) {
            for ($c = 0; $c < 11; $c++) {
                $inTopLeft = ($r < 4 && $c < 4);
                $inTopRight = ($r < 4 && $c > 6);
                $inBottomLeft = ($r > 6 && $c < 4);
                if ($inTopLeft || $inTopRight || $inBottomLeft) {
                    continue;
                }
                $bit = hexdec($hash[($r * 11 + $c) % 32]) % 2 === 0;
                if ($bit) {
                    $x = $offset + $c * $cell;
                    $y = 64 + $r * $cell;
                    $rects .= "<rect x=\"{$x}\" y=\"{$y}\" width=\"10\" height=\"10\" rx=\"2\" fill=\"#0f172a\"/>";
                }
            }
        }

        $safeName = htmlspecialchars(mb_strimwidth($merchantName, 0, 26, '...'), ENT_QUOTES, 'UTF-8');
        $svg = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 220 250" width="440" height="500">
  <rect width="220" height="250" rx="18" fill="#ffffff"/>
  <rect x="6" y="6" width="208" height="238" rx="14" fill="#f8fafc" stroke="#dbeafe" stroke-width="2"/>
  <text x="110" y="30" text-anchor="middle" font-family="sans-serif" font-size="13" font-weight="800" fill="#1d4ed8">QRIS PENTACART</text>
  <text x="110" y="46" text-anchor="middle" font-family="sans-serif" font-size="9" font-weight="600" fill="#475569">{$safeName}</text>
  <rect x="34" y="54" width="152" height="152" rx="12" fill="#ffffff" stroke="#e2e8f0" stroke-width="1.5"/>
  <rect x="44" y="64" width="38" height="38" rx="6" fill="none" stroke="#1d4ed8" stroke-width="6"/>
  <rect x="55" y="75" width="16" height="16" rx="3" fill="#0f172a"/>
  <rect x="138" y="64" width="38" height="38" rx="6" fill="none" stroke="#1d4ed8" stroke-width="6"/>
  <rect x="149" y="75" width="16" height="16" rx="3" fill="#0f172a"/>
  <rect x="44" y="158" width="38" height="38" rx="6" fill="none" stroke="#1d4ed8" stroke-width="6"/>
  <rect x="55" y="169" width="16" height="16" rx="3" fill="#0f172a"/>
  {$rects}
  <text x="110" y="226" text-anchor="middle" font-family="sans-serif" font-size="9" font-weight="700" fill="#1e40af">SCAN &amp; BAYAR &#8226; IDN KAMPUS</text>
</svg>
SVG;

        Storage::disk('public')->put($path, $svg);

        return $path;
    }

    public function run(): void
    {
        // Seeder murni 10 lapak data riil mahasiswa kampus IDN (tanpa dummy)
        $this->call(StudentMerchantSeeder::class);
    }
}
