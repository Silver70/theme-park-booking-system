<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserDeletionController extends Controller
{
    /**
     * Safely delete a user and all related records
     */
    public function safeDelete(Request $request, User $user)
    {
        try {
            DB::transaction(function () use ($user) {
                // Delete related records in correct order
                
                // 1. Delete ferry tickets (depends on bookings and users)
                $user->ferryTickets()->delete();
                
                // 2. Delete ferry ticket requests (already has cascade delete)
                // This will be handled automatically due to existing cascade
                
                // 3. Delete bookings (depends on users)
                $user->bookings()->delete();
                
                // 4. Finally delete the user
                $user->delete();
            });

            return response()->json([
                'success' => true,
                'message' => 'User and all related records deleted successfully.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting user: ' . $e->getMessage()
            ], 500);
        }
    }
}
