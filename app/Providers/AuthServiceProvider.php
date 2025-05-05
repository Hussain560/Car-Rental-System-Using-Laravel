namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Booking;
use App\Models\Vehicle;
use App\Models\Maintenance;
use App\Models\Office;
use App\Models\Admin;
use App\Models\CarRentalUser;
use App\Policies\BookingPolicy;
use App\Policies\VehiclePolicy;
use App\Policies\MaintenancePolicy;
use App\Policies\OfficePolicy;
use App\Policies\AdminPolicy;
use App\Policies\UserPolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Booking::class => BookingPolicy::class,
        Vehicle::class => VehiclePolicy::class,
        Maintenance::class => MaintenancePolicy::class,
        Office::class => OfficePolicy::class,
        Admin::class => AdminPolicy::class,
        CarRentalUser::class => UserPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();

        // Define additional gates for specific actions
        Gate::define('manage-employees', function ($user) {
            return $user->Role === 'Manager';
        });

        Gate::define('manage-offices', function ($user) {
            return $user->Role === 'Manager';
        });

        Gate::define('view-reports', function ($user) {
            return in_array($user->Role, ['Manager', 'Employee']);
        });

        Gate::define('export-data', function ($user) {
            return $user->Role === 'Manager';
        });

        Gate::define('manage-system-settings', function ($user) {
            return $user->Role === 'Manager';
        });
    }
}