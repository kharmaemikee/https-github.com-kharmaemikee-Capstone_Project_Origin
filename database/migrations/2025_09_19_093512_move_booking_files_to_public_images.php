<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Move existing booking files from storage/app/public to public/images
        $bookings = DB::table('bookings')
            ->whereNotNull('downpayment_receipt_path')
            ->orWhereNotNull('valid_id_image_path')
            ->orWhereNotNull('senior_id_image_path')
            ->orWhereNotNull('pwd_id_image_path')
            ->get();

        foreach ($bookings as $booking) {
            $fields = ['downpayment_receipt_path', 'valid_id_image_path', 'senior_id_image_path', 'pwd_id_image_path'];
            
            foreach ($fields as $field) {
                if ($booking->$field) {
                    $oldPath = storage_path('app/public/' . $booking->$field);
                    $newFilename = $this->generateNewFilename($field, $booking->$field);
                    $newPath = public_path('images/' . $newFilename);
                    
                    if (File::exists($oldPath)) {
                        // Create images directory if it doesn't exist
                        if (!File::exists(public_path('images'))) {
                            File::makeDirectory(public_path('images'), 0755, true);
                        }
                        
                        // Move file
                        File::move($oldPath, $newPath);
                        
                        // Update database path
                        DB::table('bookings')
                            ->where('id', $booking->id)
                            ->update([$field => 'images/' . $newFilename]);
                    }
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Move files back from public/images to storage/app/public
        $bookings = DB::table('bookings')
            ->whereNotNull('downpayment_receipt_path')
            ->orWhereNotNull('valid_id_image_path')
            ->orWhereNotNull('senior_id_image_path')
            ->orWhereNotNull('pwd_id_image_path')
            ->get();

        foreach ($bookings as $booking) {
            $fields = ['downpayment_receipt_path', 'valid_id_image_path', 'senior_id_image_path', 'pwd_id_image_path'];
            
            foreach ($fields as $field) {
                if ($booking->$field && str_starts_with($booking->$field, 'images/')) {
                    $oldPath = public_path($booking->$field);
                    $newPath = storage_path('app/public/' . $booking->$field);
                    
                    if (File::exists($oldPath)) {
                        // Create directory if it doesn't exist
                        $dir = dirname($newPath);
                        if (!File::exists($dir)) {
                            File::makeDirectory($dir, 0755, true);
                        }
                        
                        // Move file back
                        File::move($oldPath, $newPath);
                    }
                }
            }
        }
    }

    private function generateNewFilename($field, $oldPath)
    {
        $extension = pathinfo($oldPath, PATHINFO_EXTENSION);
        $prefix = match($field) {
            'downpayment_receipt_path' => 'dp_',
            'valid_id_image_path' => 'id_',
            'senior_id_image_path' => 'senior_',
            'pwd_id_image_path' => 'pwd_',
            default => 'file_'
        };
        
        return $prefix . time() . '_' . uniqid() . '.' . $extension;
    }
};