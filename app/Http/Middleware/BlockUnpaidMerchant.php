<?php

namespace App\Http\Middleware;

use App\Models\Merchant;
use Closure;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class BlockUnpaidMerchant
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $token = explode('/', $request->path())[2];
        $merchant = Merchant::where('Token', $token)->firstOrFail();
        if (!empty($merchant->billings()->where('Terbayar', true)->where('JatuhTempo', '>', now())->first())) {
            return response()->json(
                [
                    'message' => 'Sorry, your access to our API is currently being restricted due to an unpaid bill. Complete the payment immediately, and enjoy our services again.',
                    'data' => []
                ],
                Response::HTTP_PAYMENT_REQUIRED
            );
        }

        return $next($request);
    }
}
