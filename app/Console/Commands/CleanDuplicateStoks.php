<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Stok;

class CleanDuplicateStoks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stok:clean-duplicates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean duplicate stok entries and fix negative values';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Cleaning duplicate stok entries...');

        // Hapus duplikat dengan menyimpan yang paling baru
        DB::statement("
            DELETE s1 FROM stoks s1
            INNER JOIN stoks s2 
            WHERE s1.id < s2.id 
            AND s1.mobil_id = s2.mobil_id 
            AND s1.date = s2.date
        ");

        $this->info('Duplicate entries removed.');

        // Perbaiki nilai stok negatif
        $negativeStoks = Stok::where('stok', '<', 0)->get();
        foreach ($negativeStoks as $stok) {
            $this->warn("Stok negatif ditemukan untuk mobil ID {$stok->mobil_id} tanggal {$stok->date}: {$stok->stok}");
            // Set stok negatif menjadi 0
            $stok->update(['stok' => 0]);
        }

        if ($negativeStoks->count() > 0) {
            $this->info("{$negativeStoks->count()} entri stok negatif telah diperbaiki.");
        } else {
            $this->info("Tidak ada entri stok negatif yang ditemukan.");
        }

        $this->info('Stok cleaning completed.');
    }
}
