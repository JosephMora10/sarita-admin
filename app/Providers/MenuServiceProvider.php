<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider
{
  /**
   * Register services.
   */
  public function register(): void
  {
    //
  }

  /**
   * Bootstrap services.
   */
  public function boot(): void
  {
    // Usar View Composer para filtrar el menú dinámicamente según el usuario autenticado
    View::composer('*', function ($view) {
      $verticalMenuJson = file_get_contents(base_path('resources/menu/verticalMenu.json'));
      $verticalMenuData = json_decode($verticalMenuJson);

      // Verificar si hay un usuario autenticado
      if (Auth::check()) {
        $user = Auth::user();
        
        // Si NO es admin (role = 0), filtrar el menú
        if ($user->role !== true) {
          $filteredMenu = array_filter($verticalMenuData->menu, function($item) {
            // Slugs que solo pueden ver los admins
            $adminSlugs = ['dashboard', 'users', 'products', 'categories'];
            
            // Remover headers administrativos y comerciales
            if (isset($item->menuHeader)) {
              return !in_array($item->menuHeader, ['Administrativo', 'Comercial']);
            }
            
            // Remover items con slug de admin
            if (isset($item->slug)) {
              return !in_array($item->slug, $adminSlugs);
            }
            
            return true;
          });
          
          // Re-indexar el array
          $verticalMenuData->menu = array_values($filteredMenu);
        }
      }

      // Compartir el menú filtrado con todas las vistas
      $view->with('menuData', [$verticalMenuData]);
    });
  }
}