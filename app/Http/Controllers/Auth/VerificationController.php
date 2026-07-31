<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\VerifyEmailMail;
use App\Models\VerificationToken;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class VerificationController extends Controller
{
    public function checkEmail(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
        ]);

        $email = $validated['email'];
        $customer = Customer::where('email', $email)->first();

        // Email no existe
        if (!$customer) {
            return response()->json([
                'status' => 'new',
                'message' => 'Email no registrado',
            ]);
        }

        // Email existe sin contraseña (necesita crear contraseña)
        if ($customer && !$customer->password) {
            return response()->json([
                'status' => 'needs-password',
                'message' => 'Completa tu registro',
            ]);
        }

        // Email existe con contraseña (ya está registrado)
        return response()->json([
            'status' => 'exists',
            'message' => 'Email ya registrado',
        ]);
    }

    public function sendVerificationEmail(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
        ]);

        $email = $validated['email'];

        // Generar y guardar token en BD
        $token = VerificationToken::createToken($email);

        try {
            // Enviar email
            Mail::to($email)->send(new VerifyEmailMail($email, $token));

            return response()->json([
                'success' => true,
                'message' => 'Email enviado correctamente. Revisa tu correo.',
            ]);
        } catch (\Exception $e) {
            Log::error('Error al enviar email de verificación', [
                'email' => $email,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error al enviar el email. Intenta de nuevo.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
