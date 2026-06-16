<?php

namespace Tests\Feature;

use App\Http\Middleware\CheckOffreAccess;
use App\Models\Entreprise\Offre;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use ReflectionProperty;
use Tests\TestCase;

class CheckOffreAccessTest extends TestCase
{
    public function test_allows_admin_access_when_route_param_is_already_an_offre_model(): void
    {
        $user = new User([
            'id' => 1,
            'account_type' => 'admin',
        ]);

        $offre = new Offre([
            'id' => 5,
            'entreprise_id' => 10,
        ]);
        $offre->exists = true;

        Auth::shouldReceive('user')->andReturn($user);

        $request = Request::create('/admin/offres/5', 'GET');
        $request->setRouteResolver(function () use ($offre) {
            $route = new Route('GET', '/admin/offres/{offre}', []);

            $property = new ReflectionProperty(Route::class, 'parameters');
            $property->setAccessible(true);
            $property->setValue($route, ['offre' => $offre]);

            return $route;
        });

        $middleware = new CheckOffreAccess();

        $response = $middleware->handle($request, function ($request) {
            return response('ok', 200);
        });

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame('ok', $response->getContent());
    }
}
