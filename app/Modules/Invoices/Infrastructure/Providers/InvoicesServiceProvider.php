<?php declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Providers;

use App\Modules\Invoices\Api\InvoicesFacadeInterface;
use App\Modules\Invoices\Application\InvoicesFacade;
use App\Modules\Invoices\Domain\Repository\InvoiceRepositoryInterface;
use App\Modules\Invoices\Infrastructure\Database\Repository\InvoiceRepository;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class InvoicesServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function register(): void
    {
        $this->app->scoped(InvoicesFacadeInterface::class, InvoicesFacade::class);
        $this->app->scoped(InvoiceRepositoryInterface::class, InvoiceRepository::class);
    }

    /** @return array<class-string> */
    public function provides(): array
    {
        return [
            InvoicesFacadeInterface::class,
            InvoiceRepositoryInterface::class,
        ];
    }
}
