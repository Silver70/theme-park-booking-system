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
           
                $user->ferryTickets()->delete();
                
                
                $user->bookings()->delete();
                
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
