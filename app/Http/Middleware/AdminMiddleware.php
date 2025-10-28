public function handle(Request $request, Closure $next)
{
    if (!auth()->check()) {
        return redirect()->route('login');
    }

    if (auth()->user()->role !== 'admin') {
        return redirect()->route('dashboard')->with('error', 'No tienes permisos de administrador');
    }

    return $next($request);
}